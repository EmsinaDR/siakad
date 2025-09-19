<?php

namespace App\Console\Commands\Absensi;

use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Absensi\Eabsen;
use App\Models\Admin\Identitas;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User\Siswa\Detailsiswa;

class CekAbsenKosongSiswa extends Command
{
    protected $signature = 'siakad:CekAbsenKosongSiswa';
    protected $description = 'Mengisi absen alfa otomatis untuk siswa yang tidak absen';

    public function handle()
    {
        $jamSekarang     = now()->format('H:i');
        $jamBatasMasuk   = '07:00';
        $jamBatasPulang  = '13:00';
        // dd($jamBatasMasuk);

        if ($jamSekarang >= '06:00' && $jamSekarang < '10:00') {
            // Sudah lewat jam masuk, belum waktu pulang
            $this->prosesAbsen('masuk');
        }

        if ($jamSekarang >= '13:00') {
            // Sudah lewat jam pulang
            $this->prosesAbsen('pulang');
        }
    }
    protected function prosesAbsen($jenisAbsen)
    {
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $jamSekarang = now();
        $sessions = config('whatsappSession.IdWaUtama');
        $Identitas = Identitas::first();

        $sudahAbsen = Eabsen::whereDate('waktu_absen', Carbon::today())
            ->where('jenis_absen', $jenisAbsen)
            ->pluck('detailsiswa_id')
            ->toArray();

        if (!config('whatsappSession.WhatsappDev')) {
            $siswaBelumAbsen = Detailsiswa::whereNotNull('kelas_id')
                ->whereNotIn('id', $sudahAbsen)
                ->get();
        } else {
            $siswaBelumAbsen = Detailsiswa::whereNotNull('kelas_id')
                ->whereNotIn('id', $sudahAbsen)
                ->limit(5)
                ->get();
        }
        foreach ($siswaBelumAbsen as $siswa) {
            $Absen = Eabsen::create([
                'detailsiswa_id' => $siswa->id,
                'tapel_id'       => $etapels->id ?? null,
                'semester'       => $etapels->semester ?? null,
                'kelas_id'       => $siswa->kelas_id,
                'absen'          => 'alfa',
                'jenis_absen'    => $jenisAbsen,
                'waktu_absen'    => $jamSekarang,
            ]);

            $tanggal = Carbon::now()->translatedFormat('l, d F Y');
            $nama    = $siswa->nama_siswa;
            $kelas   = $siswa->kelasOne->nama_kelas ?? '-'; // pastikan field yg bener

            $message =
                "Selamat {$tanggal} Bp / Ibu, Kami menyampaikan terkait dengan absensi kehadiran ananda *{$nama}* sebagai berikut : \n\n" .
                "📝 Nama\t\t: {$nama}\n" .
                "🏫 Kelas\t\t: {$kelas}\n" .
                "📅 Tanggal\t: {$tanggal}\n" .
                "⏰ Jam\t\t\t: {$jamSekarang} WIB\n" .
                "📒 Keterangan : *Alfa System*\n" .
                ($telat ?? '') . "\n" .
                "\n" . str_repeat("─", 25) . "\n" .
                "Kami mohon agar Bapak / Ibu terus bersama membimbing ananda *{$nama}* agar selalu menaati peraturan sekolah.\n";
            if (!config('whatsappSession.WhatsappDev')) {
                if (!config('whatsappSession.SingleSession')) {
                    $sessions = getWaSession($siswa->tingkat_id); // jika single whatsapp kosongkan tingkat
                } else {
                    $sessions = getWaSession();
                }
                $NoTujuan = getNoTujuanOrtu($siswa);
            } else {
                $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            // Pesan Ke Ortu
            // $pesanKiriman = format_pesan('Laporan Absensi', $message);
            // $ResponWa = WhatsApp::sendMessage($sessions, $NoTujuan, $pesanKiriman);
            // // langsung update field whatsapp_response
            // $Absen->update([
            //     'whatsapp_response' => $ResponWa['status'] ?? null,
            // ]);
        }
        $jumlahSiswa = count($siswaBelumAbsen);
        $kelasList = Ekelas::where('tapel_id', $etapels->id)->get();
        $SiswaKelas = '';
        foreach ($kelasList as $kelas) {
            $jumlah = $siswaBelumAbsen->where('kelas_id', $kelas->id)->count();
            $SiswaKelas .= "Kelas {$kelas->kelas} \t\t\t\t\t\t: {$jumlah} Siswa\n";
        }

        $pesanAlfa =
            "==============================\n" .
            "📌 *Data Siswa Tidak Absen System*\n" .
            "==============================\n\n" .
            "Siswa tidak absen sistem: {$jumlahSiswa} Siswa\n" .
            "Status telah dibuat *alfa* otomatis per kelas :\n{$SiswaKelas}";

        $rekapPerKelas = Eabsen::whereDate('waktu_absen', Carbon::today())
            ->where('jenis_absen', $jenisAbsen)
            ->where('tapel_id', $etapels->id ?? null)
            ->select('kelas_id', 'absen', DB::raw('count(*) as total'))
            ->groupBy('kelas_id', 'absen')
            ->get();

        // Ambil daftar kelas sekaligus, supaya bisa dipanggil nama kelasnya
        $kelasList = Ekelas::where('tapel_id', $etapels->id ?? null)->get()->keyBy('id');

        $pesanKelas = "\n\n\n";

        foreach ($kelasList as $kelas) {
            $siswaAlfaSystem = Detailsiswa::whereNotIn('id', $sudahAbsen)->where('kelas_id', $kelas->id)->get();
            // dd($siswaAlfaSystem);
            $daftarNama = '';
            foreach ($siswaAlfaSystem as $index => $siswaNotAbsen) {
                $daftarNama .= $index + 1 . "." . $siswaNotAbsen->nama_siswa . "\n";
            }
            // Filter hasil rekap sesuai kelas ini
            $dataKelas = $rekapPerKelas->where('kelas_id', $kelas->id);

            // Buat array default supaya semua status muncul meskipun 0
            $status = ['hadir' => 0, 'alfa' => 0, 'ijin' => 0, 'sakit' => 0];

            foreach ($dataKelas as $item) {
                $status[strtolower($item->absen)] = $item->total;
            }

            $pesanKelas .= "==============================\n";
            $pesanKelas .= "🏫 *Rekap Absensi Kelas {$kelas->kelas}*\n";
            $pesanKelas .= "==============================\n\n";
            $pesanKelas .= "✅ Hadir \t\t\t\t\t\t: {$status['hadir']}\n";
            $pesanKelas .= "❌ Alfa  \t\t\t\t\t\t\t: {$status['alfa']}\n";
            $pesanKelas .= "📝 Ijin  \t\t\t\t\t\t\t: {$status['ijin']}\n";
            $pesanKelas .= "🤒 Sakit \t\t\t\t\t\t: {$status['sakit']}\n\n";
            $pesanKelas .= "Berikut Daftar Nama Siswa Alfa melalui Sistem :\n";
            $pesanKelas .= "{$daftarNama}\n";
        }
        $footerPesan = "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";
        $pesan = $pesanAlfa . $pesanKelas . $footerPesan;

        if (!config('whatsappSession.WhatsappDev')) {
            $NoPenerima = $Identitas->phone;
        } else {
            $NoPenerima = config('whatsappSession.DevNomorTujuan');
        }

        \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, config('whatsappSession.NoKepala'), $pesan);
        /*
            |--------------------------------------------------------------------------
            | 📌 Pesan Untuk Wali Kelas :
            |--------------------------------------------------------------------------
            |
            | Fitur :
            | - Pengiriman pesan absensi harian ke wali kelas
            |
        */
        // Kirim ke wali kelas
        $pesanWaliKelas = "\n\n\n";

        foreach ($kelasList as $kelas) {

            $siswaAlfaSystem = Detailsiswa::whereNotIn('id', $sudahAbsen)->where('kelas_id', $kelas->id)->get();
            // dd($siswaAlfaSystem);
            $daftarNama = '';
            foreach ($siswaAlfaSystem as $index => $siswaNotAbsen) {
                $daftarNama .= $index + 1 . "." . $siswaNotAbsen->nama_siswa . "\n";
            }
            // Filter hasil rekap sesuai kelas ini
            $dataKelas = $rekapPerKelas->where('kelas_id', $kelas->id);

            // Array default supaya semua status muncul walau 0
            $status = ['hadir' => 0, 'alfa' => 0, 'ijin' => 0, 'sakit' => 0];

            foreach ($dataKelas as $item) {
                $status[strtolower($item->absen)] = $item->total;
            }

            // Reset pesan per kelas
            if ($kelas->Guru->jenis_kelamin === 'Perempuan') {
                $sapaan = 'Ibu';
            } else {
                $sapaan = 'Bapak';
            }
            $pesanWaliKelas = "";
            $pesanWaliKelas .= "==============================\n";
            $pesanWaliKelas .= "🏫 *Rekap Absensi Kelas {$kelas->kelas}*\n";
            $pesanWaliKelas .= "==============================\n\n";
            $pesanWaliKelas .= "Selama pagi {$sapaan} {$kelas->Guru->nama_guru},{$kelas->Guru->gelar} , data rekap absnesi hari ini kelas {$kelas->kelas} sebagai berikut : \n";
            $pesanWaliKelas .= "✅ Hadir \t\t\t\t\t\t: {$status['hadir']}\n";
            $pesanWaliKelas .= "❌ Alfa  \t\t\t\t\t\t\t: {$status['alfa']}\n";
            $pesanWaliKelas .= "📝 Ijin  \t\t\t\t\t\t\t: {$status['ijin']}\n";
            $pesanWaliKelas .= "🤒 Sakit \t\t\t\t\t\t: {$status['sakit']}\n\n";
            $pesanWaliKelas .= "Berikut Daftar Nama Siswa Alfa System\n";
            $pesanWaliKelas .= "Berikut Daftar Nama Siswa Alfa melalui Sistem :\n";
            $pesanWaliKelas .= "{$daftarNama}\n";

            $footerPesan = "\n" . str_repeat("─", 25) . "\n" .
                "✍️ Dikirim oleh:\n" .
                "*Boot Assistant Pelayanan {$Identitas->namasek}*";
            $sapaan = $kelas->Guru->jenis_kelamin;
            $pesan = $pesanWaliKelas . $footerPesan . "\n";
            if (!config('whatsappSession.WhatsappDev')) {
                $NoPenerima = $kelas->Guru->no_hp ?? config('whatsappSession.SekolahNoTujuan');
            } else {
                $NoPenerima = config('whatsappSession.DevNomorTujuan');
            }
            // Kirim pesan WA, ganti nomor di sini sesuai wali kelas
            \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoPenerima, $pesan);
        }

        $this->info("Absen $jenisAbsen selesai. Total siswa alfa : {$jumlahSiswa}");
        return 0;
    }
}
