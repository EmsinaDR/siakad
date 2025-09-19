<?php

namespace App\Console\Commands\Bendahara;

use App\Models\Admin\Identitas;
use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use App\Models\Absensi\Eabsen;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User\Siswa\Detailsiswa;

class WhatsappBulanan extends Command
{
    protected $signature = 'siakad:WhatsappBulanan';
    protected $description = 'Jadwal pesan bulanan';

    /*
        |--------------------------------------------------------------------------
        | 📌 whatsapp
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | -
        |
        | Tujuan :
        | - Pengiriman Pesan Bulanan Pengingat Pembayaran
        | -
        |
        |
        | Penggunaan :
        | - Jelaskan penggunaannya dimana atau hubungannya
        | -
        |
        |
        |
    */

    public function handle()
    {
        //
        $identitas = Identitas::first();
        $tanggal = now()->isLastOfMonth(); // contoh tanggal
        if ($tanggal) {
            echo "Ini adalah tanggal akhir bulan.";
        } else {
            /*
                |--------------------------------------------------------------------------
                | 📌 Pengingat Pembayaran
                |--------------------------------------------------------------------------
            */
            if (!config('whatsappSession.WhatsappDev')) {
                $Siswas = Detailsiswa::SiswaAktif()->whereNotNull('kelas_id')->get();
            } else {
                $Siswas = Detailsiswa::SiswaAktif()->whereNotNull('kelas_id')->limit(5)->get();
            }
            foreach ($Siswas as $Siswa) {
                $Pesan =
                    "================================\n" .
                    "📌 *Pengingat Pembayaran*\n" .
                    "================================\n\n" .
                    "Di Informasikan untuk seluruh Orang Tua dan Siswa\n" .
                    "Terkait pembayaran komite / syahriah dimohon diselesaikan sebelum *tanggal 10*\n" .
                    "Atas perhatian dan kerjasamanya kami sampaikan terima kasih\n" .
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirm oleh:\n WhasappBot *$identitas->namasek* ";
                if (!config('whatsappSession.WhatsappDev')) {
                    // Produksi: menggunakan sesi berdasarkan tingkat
                    $noTujuan = $Siswa->ayah_nohp;
                    $session = getWaSessionByTingkat($Siswa->tingkat_id);
                } else {
                    // Mode dev: Kirim ke nomor dev
                    $noTujuan  = config('whatsappSession.DevNomorTujuan');
                    $session = config('whatsappSession.IdWaUtama'); //Hapus jika sudah aktif
                }
                // dd($session, $Siswas);
                WhatsApp::sendMessage($session, $noTujuan, $Pesan);
                sleep(rand(5, 10));
            }
            /*
                |--------------------------------------------------------------------------
                | 📌 Pengingat Absensi
                |--------------------------------------------------------------------------
            */
            $bulan = (int) date('n'); // Ambil bulan sekarang (1 - 12)
            $tahun = date('Y');       // Ambil tahun sekarang

            // Ambil semua ID siswa yang aktif (pakai scope `SiswaAktif`)
            $IdSiswa = Detailsiswa::SiswaAktif()->pluck('id');

            // Ambil data absensi siswa aktif berdasarkan bulan & tahun
            $rekapAbsen = Eabsen::with('detailsiswa')
                ->whereIn('detailsiswa_id', $IdSiswa)
                ->whereMonth('waktu_absen', $bulan)
                ->whereYear('waktu_absen', $tahun)
                ->selectRaw('detailsiswa_id, absen, COUNT(*) as total')
                ->groupBy('detailsiswa_id', 'absen')
                ->get();

            $dataPerSiswa = [];

            // Proses data absensi menjadi rekap per siswa
            foreach ($rekapAbsen as $rekap) {
                $id = $rekap->detailsiswa_id;

                // Inisialisasi array jika belum ada
                if (!isset($dataPerSiswa[$id])) {
                    $dataPerSiswa[$id] = [
                        'siswa'      => $rekap->detailsiswa,
                        'tingkat_id' => $rekap->detailsiswa->tingkat_id ?? null, // Ambil tingkat_id dari detailsiswa
                        'ayah_nohp'  => $rekap->detailsiswa->ayah_nohp ?? null,  // Simpan no HP ortu juga
                        'sakit'      => 0,
                        'izin'       => 0,
                        'alfa'       => 0,
                        'hadir'      => 0,
                    ];
                }

                $absen = strtolower(trim($rekap->absen)); // Pastikan konsistensi absen
                if (in_array($absen, ['sakit', 'izin', 'alfa', 'hadir'])) {
                    $dataPerSiswa[$id][$absen] = $rekap->total;
                }
            }

            // Ubah angka bulan menjadi nama (contoh: "Agustus")
            $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');

            // Kirim pesan WhatsApp ke setiap orang tua
            foreach ($dataPerSiswa as $Siswa) {

                // Tentukan nomor tujuan dan session berdasarkan mode
                if (!config('whatsappSession.WhatsappDev')) {
                    $noTujuan = $Siswa['ayah_nohp'];
                    $session = getWaSessionByTingkat($Siswa['tingkat_id']); // Ambil session berdasar tingkat
                } else {
                    $noTujuan = config('whatsappSession.DevNomorTujuan');
                    $session = 'GuruId'; // Ganti kalau sudah pakai ID sesungguhnya
                }

                $namaSiswa    = $Siswa['siswa']->nama_siswa ?? 'Nama tidak ditemukan';
                $noTujuanOrtu = $noTujuan ?? config('whatsappSession.DevNomorTujuan');
                $hadir        = $Siswa['hadir'] ?? 0;
                $alfa         = $Siswa['alfa'] ?? 0;
                $izin         = $Siswa['izin'] ?? 0;
                $sakit        = $Siswa['sakit'] ?? 0;

                // Format isi pesan WhatsApp
                $Pesan =
                    "================================\n" .
                    "📊 *Rekap Kehadiran Bulan $namaBulan $tahun*\n" .
                    "================================\n" .
                    "Nama\t\t\t : $namaSiswa\n" .
                    "Hadir\t\t\t : $hadir\n" .
                    "Alfa\t\t\t\t : $alfa\n" .
                    "Izin\t\t\t\t : $izin\n" .
                    "Sakit\t\t\t : $sakit\n\n" .
                    "Demikian informasi rekap kehadiran selama bulan *$namaBulan $tahun*.\n" .
                    "Kami harap Bapak/Ibu dapat terus memantau kehadiran ananda $namaSiswa dan memberikan dukungan terbaik.\n" .
                    "Apabila ada hal yang perlu dikonsultasikan, silakan menghubungi wali kelas masing-masing.\n" .
                    "================================\n" .
                    "✍️ Dikirm oleh:\n WhasappBot *$identitas->namasek* ";

                // Kirim via WA API
                WhatsApp::sendMessage($session, $noTujuanOrtu, $Pesan);

                // Delay acak 5–10 detik biar nggak disangka spam
                sleep(rand(5, 10));
            }
        }
    }
}
// foreach ($Absen as $Siswa) {
//     $Pesan =
//         "================================\n" .
//         "📌 *Pengingat Pembayaran*\n" .
//         "================================\n\n" .
//         "Di Informasikan untuk seluruh Orang Tua dan Siswa\n" .
//         "Terkait pembayaran komite / syahriah dimohon diselesaikan sebelum *tanggal 10 Bulan*\n" .
//         "Atas perhatian dan kerjasamanya kami sampaikan terima kasih\n" .
//         "\n" . str_repeat("─", 25) . "\n" .
//         "✍️ Dikirm oleh:\n WhasappBot Sekolah";
//     $session =  config('whatsappSession.IdWaUtama');
//     // dd($session, $Siswas);
// }

/*

$schedule->command('siakad:WhatsappBulanan')
         ->daily()
         ->when(fn () => now()->isLastOfMonth())
         ->runInBackground();
*/