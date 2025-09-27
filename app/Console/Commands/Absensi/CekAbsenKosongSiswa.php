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

        if ($jamSekarang >= '01:00' && $jamSekarang < '10:00') {
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
            $siswaBelumAbsen = Detailsiswa::with('kelas')->whereNotNull('kelas_id')
                ->whereNotIn('id', $sudahAbsen)
                ->get();
        } else {
            $siswaBelumAbsen = Detailsiswa::with('kelas')->whereNotNull('kelas_id')
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
            $jam = $jamSekarang->format('H:i');
            $message =
                "Selamat {$tanggal} Bp / Ibu, Kami menyampaikan terkait dengan absensi kehadiran ananda *{$nama}* sebagai berikut : \n\n" .
                "📝 Nama\t\t: {$nama}\n" .
                "🏫 Kelas\t\t: {$kelas}\n" .
                "📅 Tanggal\t: {$tanggal}\n" .
                "⏰ Jam\t\t\t: {$jam} WIB\n" .
                "📒 Keterangan : *Alfa System*\n" .
                ($telat ?? '') . "\n" .
                "\n" . str_repeat("─", 25) . "\n" .
                "Kami mohon agar Bapak / Ibu terus bersama membimbing ananda *{$nama}* agar selalu menaati peraturan sekolah.\n";
            if (!config('whatsappSession.WhatsappDev')) {
                // if (!config('whatsappSession.SingleSession')) {
                //     $sessions = getWaSession(); // jika single whatsapp kosongkan tingkat
                // } else {
                //     $sessions = getWaSession();
                // }
                $sessions = getWaSession(); // jika single whatsapp kosongkan tingkat
                $NoTujuan = getNoTujuanOrtu($siswa);
            } else {
                $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            // Kirim Ke ortu : Pesan Ke Ortu
            $pesanKiriman = format_pesan('Laporan Absensi', $message);
            $ResponWa = WhatsApp::sendMessage($sessions, $NoTujuan, $pesanKiriman);
            // langsung update field whatsapp_response
            $Absen->update([
                'whatsapp_response' => $ResponWa['status'] ?? null,
            ]);
        }
        // Batas Akhir Orang Tua













        /*
            |--------------------------------------------------------------------------
            | 📌 Wali Kelas :
            |--------------------------------------------------------------------------
            |
            | Fitur :
            | - xxxxxxxxxxx
            | - xxxxxxxxxxx
            |
            | Tujuan :
            | - xxxxxxxxxxx
            |
            |
            | Penggunaan :
            | - xxxxxxxxxxx
            |
            */
        // Proses Coding
        // Rekap semua Kelas
        $jumlahSiswa = count($siswaBelumAbsen);
        $kelasList = Ekelas::with('Guru')->where('tapel_id', $etapels->id)->get();

        $SiswaKelas = '';
        foreach ($kelasList as $kelas) {
            $Alfa = Eabsen::whereDate('created_at', Carbon::today())->where('absen', 'alfa')->where('kelas_id', $kelas->id)->where('jenis_absen', $jenisAbsen)->get();
            $SiswaKelas .= "Kelas {$kelas->kelas} \t\t\t\t\t\t: {$Alfa->count()} Siswa\n";
        }

        $rekapPerKelas = Eabsen::whereDate('waktu_absen', Carbon::today())
            ->where('jenis_absen', $jenisAbsen)
            ->where('tapel_id', $etapels->id ?? null)
            ->select('kelas_id', 'absen', DB::raw('count(*) as total'))
            ->groupBy('kelas_id', 'absen')
            ->get();


        foreach ($kelasList as $kelas) {
            // $siswaAlfaSystem = Detailsiswa::whereNotIn('id', $sudahAbsen)->where('kelas_id', $kelas->id)->get();
            // ambil detailsiswa_id
            // dd($kelas);
            $Alfa = Eabsen::whereDate('created_at', Carbon::today())->where('absen', 'alfa')->where('kelas_id', $kelas->id)->where('jenis_absen', $jenisAbsen)->get();
            $Hadir = Eabsen::whereDate('created_at', Carbon::today())->where('absen', 'hadir')->where('kelas_id', $kelas->id)->where('jenis_absen', $jenisAbsen)->get();
            $Ijin = Eabsen::whereDate('created_at', Carbon::today())->where('absen', 'ijin')->where('kelas_id', $kelas->id)->where('jenis_absen', $jenisAbsen)->get();
            $Sakit = Eabsen::whereDate('created_at', Carbon::today())->where('absen', 'sakit')->where('kelas_id', $kelas->id)->where('jenis_absen', $jenisAbsen)->get();
            // Data Siswa Alfa
            $today = Carbon::now()->toDateString(); // "2025-09-24"
            $DataAlfa = Eabsen::whereDate('created_at', $today)->where('absen', 'alfa')->pluck('detailsiswa_id')->toArray();
            $SiswaAlfa = Detailsiswa::whereIn('id', $DataAlfa)->where('kelas_id', $kelas->id)->get();
            $daftarNama = '';
            foreach ($SiswaAlfa as $index => $alfa):
                $daftarNama .= $index + 1 . "." . $alfa->nama_siswa . "\n";
            endforeach;
            // dd($daftarNama);


            // Buat array default supaya semua status muncul meskipun 0
            $status = ['hadir' => 0, 'alfa' => 0, 'ijin' => 0, 'sakit' => 0];

            // foreach ($dataKelas as $item) {
            //     $status[strtolower($item->absen)] = $item->total;
            // }
            $pesanKelas = "\n";
            $pesanKelas .= "✅ Hadir \t\t\t\t\t\t: {$Hadir->count()}\n";
            $pesanKelas .= "❌ Alfa  \t\t\t\t\t\t\t: {$Alfa->count()}\n";
            $pesanKelas .= "📝 Ijin  \t\t\t\t\t\t\t: {$Ijin->count()}\n";
            $pesanKelas .= "🤒 Sakit \t\t\t\t\t\t: {$Sakit->count()}\n\n";
            if ($Alfa->count() > 0) {
                $pesanKelas .= str_repeat("─", 25) . "\n";
                $pesanKelas .= "Berikut Daftar Nama Siswa Alfa dikelas :\n";
                $pesanKelas .= "{$daftarNama}\n";
            } else {
                $pesanKelas .= str_repeat("─", 25) . "\n";
                $pesanKelas .= "Kelas ini tidak memiliki siswa alfa!\n";
            }

            // $pesan = $pesanAlfa . $pesanKelas . $footerPesan;

            // Walkes
            // bagian kirim ke wali kelas
            $waktuSapaan = $jenisAbsen === 'masuk' ? 'Pagi' : 'Siang';
            $nama_wali = $kelas->Guru->nama_guru;
            $gelar = $kelas->Guru->gelar;
            $kelasSIswa = $kelas->kelas;
            $PesanWalkes = "\n";
            $pesan =
                "Selamat {$waktuSapaan} Bapak / Ibu {$nama_wali}, {$gelar} berikut untuk data absensi rekap {$jenisAbsen} hari ini sebagai informasi wali kelas.\n" .
                "{$pesanKelas}\n" .
                "Kami sampaikan banyak terima kasih telah membimbing kelas dengan sabar.\n" .
                "\n";
            if (!config('whatsappSession.WhatsappDev')) {
                $NoPenerima = $kelas->Guru->no_hp;
            } else {
                $NoPenerima = config('whatsappSession.DevNomorTujuan');
            }
            // pesan wali kelas
            $ResponWa = WhatsApp::sendMessage($sessions, $NoPenerima, format_pesan("🏫 Rekap Absensi Kelas {$kelasSIswa}", $pesan));

            $this->info("Absen $jenisAbsen selesai.\nKelas :{$kelas}\nTotal siswa alfa : {$Alfa->count()} \n" . str_repeat("─", 25) . "\n");
            // Netralkan pesan dan rekap pesan untuk kepala
            $pesan = '';
            $pesanKelas = '';
            // $pesanKepala = "";
            // $pesanKepala .= $pesan;
            // Netralkan pesan dan rekap pesan untuk kepala
            // Pengiriman Wali Kelas selesai
            sleep(rand(4, 10));
        }

        // Tujuan Kepala
        // Ambil daftar kelas sekaligus, supaya bisa dipanggil nama kelasnya
        $kelasList = Ekelas::where('tapel_id', $etapels->id ?? null)->get()->keyBy('id');
        $kelasList = Ekelas::where('tapel_id', $etapels->id)->orderBy('id', 'ASC')->get();
        $pesanAlfa =
            "==============================\n" .
            "📌 *Data Siswa Tidak Absen System*\n" .
            "==============================\n\n" .
            "Siswa tidak absen sistem: {$siswaBelumAbsen->count()} Siswa\n" .
            "Status telah dibuat *alfa* otomatis per kelas :\n{$SiswaKelas}";
        // Rekap Kepala
        $LaporanAlfaKepala = Eabsen::whereDate('created_at', Carbon::today())->where('absen', 'alfa')->where('jenis_absen', $jenisAbsen)->get();
        $DfNama = '';
        foreach ($LaporanAlfaKepala as $index => $dataSiswaKepala) {
            $DfNama .= $index + 1 . "." . $dataSiswaKepala->detailsiswa->nama_siswa . "/" . $dataSiswaKepala->detailsiswa->kelasOne->kelas . "\n";
        }
        if (!config('whatsappSession.WhatsappDev')) {
            $NoPenerima = config('whatsappSession.NoKepala');
        } else {
            $NoPenerima = config('whatsappSession.DevNomorTujuan');
        }
        $pesanKelas = '';
        $pesanKelas .= "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";
        $pesanKelas = $pesanAlfa .
            "\n" . str_repeat("─", 25) . "\n" .
            "Berikut daftar nama yang tercatat :\n" .
            $DfNama .
            $pesanKelas;
        // WhatsApp::sendMessage($sessions, '6285329860005', $pesanKelas);
        $ResponWa = WhatsApp::sendMessage($sessions, $NoPenerima, $pesanKelas);

        $this->info("Absen $jenisAbsen selesai. Total siswa alfa : {$jumlahSiswa}");
        return 0;
    }
}
