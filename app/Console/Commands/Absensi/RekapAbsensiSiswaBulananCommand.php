<?php

namespace App\Console\Commands\Absensi;

use Carbon\Carbon;
use App\Models\Absensi\Eabsen;
use Illuminate\Console\Command;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Siswa\Detailsiswa;

class RekapAbsensiSiswaBulananCommand extends Command
{
    protected $signature = 'absensi:rekap-bulanan';
    protected $description = 'Rekap Absensi Bulanan';

    /*
        |----------------------------------------------------------------------
        | 📌 Absensi
        |----------------------------------------------------------------------
        | Jelaskan tujuan dan contoh schedule di sini
        |
    */

    public function handle()
    {
        // Tuliskan logika command di sini
        // $now = \Carbon\Carbon::now();

        // $bulanAngka = $now->month;                 // 8
        // $tahun      = $now->year;                  // 2025
        // $namaBulan  = $now->translatedFormat('F'); // "Agustus"

        // if (!config('whatsappSession.WhatsappDev')) {
        //     $Siswa = Detailsiswa::whereNotNull('kelas_id')->get();
        // } else {
        //     $Siswa =  Detailsiswa::whereNotNull('kelas_id')->limit(5)->get();
        // }
        // $rekap = [];

        // foreach ($Siswa as $siswa) {
        //     $query = Eabsen::where('detailsiswa_id', $siswa->id) // ✅ pakai id siswa
        //         ->whereMonth('created_at', $bulanAngka)
        //         ->whereYear('created_at', $tahun);

        //     $rekap[$siswa->id] = [
        //         'nama'   => $siswa->nama,
        //         'masuk'  => [
        //             'sakit' => (clone $query)->where('jenis_absen', 'masuk')->where('absen', 'sakit')->count(),
        //             'ijin'  => (clone $query)->where('jenis_absen', 'masuk')->where('absen', 'ijin')->count(),
        //             'alfa'  => (clone $query)->where('jenis_absen', 'masuk')->where('absen', 'alfa')->count(),
        //             'bolos' => (clone $query)->where('jenis_absen', 'masuk')->where('absen', 'bolos')->count(),
        //         ],
        //         'pulang' => [
        //             'sakit' => (clone $query)->where('jenis_absen', 'pulang')->where('absen', 'sakit')->count(),
        //             'ijin'  => (clone $query)->where('jenis_absen', 'pulang')->where('absen', 'ijin')->count(),
        //             'alfa'  => (clone $query)->where('jenis_absen', 'pulang')->where('absen', 'alfa')->count(),
        //             'bolos' => (clone $query)->where('jenis_absen', 'pulang')->where('absen', 'bolos')->count(),
        //         ]
        //     ];

        //     // ✅ akses array dengan key id siswa
        //     // $this->info("{$siswa->mama_siswa} - Masuk: " . json_encode($rekap[$siswa->id]['masuk']) . " | Pulang: " . json_encode($rekap[$siswa->id]['pulang']));
        //     $title = "Rekap Absensi Bulan {$namaBulan} {$tahun}";
        //     $masuk  = $rekap[$siswa->id]['masuk'];
        //     $pulang = $rekap[$siswa->id]['pulang'];
        //     $isi =
        //         "📊 Rekap Absensi Bulan {$namaBulan} {$tahun}\n" .
        //         "👦 Ananda *{$siswa->nama_siswa}*\n" .
        //         "🏫 Kelas *{$siswa->KelasOne->kelas}*\n\n" .
        //         "➡️ *Masuk:*\n" .
        //         "   ✅ Hadir \t\t\t: {$masuk['sakit']}\n" .
        //         "   🤒 Sakit \t\t\t: {$masuk['sakit']}\n" .
        //         "   📝 Ijin  \t\t\t\t: {$masuk['ijin']}\n" .
        //         "   ❌ Alfa  \t\t\t\t: {$masuk['alfa']}\n" .
        //         "   🚶 Bolos \t\t\t: {$masuk['bolos']}\n\n" .
        //         "➡️ *Pulang:*\n" .
        //         "   ✅ Hadir \t\t\t: {$pulang['sakit']}\n" .
        //         "   🤒 Sakit \t\t\t: {$pulang['sakit']}\n" .
        //         "   📝 Ijin  \t\t\t\t: {$pulang['ijin']}\n" .
        //         "   ❌ Alfa  \t\t\t\t: {$pulang['alfa']}\n" .
        //         "   🚶 Bolos \t\t\t: {$pulang['bolos']}\n\n" .
        //         "Kami sampaikan banyak terima kasih atas perhatian dan kerjasamanya. Semoga ananda *{$siswa->nama_siswa}* dapat belajar dan terus bekembang menjadi lebih baik untuk masa depan." .
        //         "\n\n";

        //     $data2 = PesanAbsensi($siswa->id);

        //     $isiPesan = format_pesan($title, $isi);
        //     $sessions = config('whatsappSession.IdWaUtama');
        //     if (!config('whatsappSession.WhatsappDev')) {
        //         $NoTujuan = $siswa->no_hp;
        //     } else {
        //         $NoTujuan = config('whatsappSession.DevNomorTujuan');
        //     }
        //     $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, "isiPesan" . "\n\n\n" . $data2);
        // }

        if (!config('whatsappSession.WhatsappDev')) {
            $Siswa =  Detailsiswa::whereNotNull('kelas_id')->get();
        } else {
            $Siswa =  Detailsiswa::whereNotNull('kelas_id')->limit(5)->get();
        }
        foreach ($Siswa as $siswa) {

            if (!config('whatsappSession.WhatsappDev')) {
                //$sessions = getWaSessionByTingkat($Siswa->tingkat_id);
                //$sessions = config('whatsappSession.IdWaUtama');
                // $NoTujuan = $Siswa->no_hp;
            } else {
                $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            // $PesanKirim = PesanAbsensiTahunan($siswa->id);
            $PesanKirim = PesanAbsensiBulananOrtu($siswa->id);
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $PesanKirim);
        }
        $this->info("Command 'RekapBulananCommand' berhasil dijalankan.");
    }
}
