<?php

namespace App\Providers;

use App\Models\Admin\Identitas;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule; // <-- Ini yang penting bro!

class ScheduleServiceProviderClient extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->commands([
            \App\Console\Commands\Whatsapp\PenjadwalanPesanCommand::class,
            \App\Console\Commands\Absensi\CekAbsenKosongSiswa::class,
            \App\Console\Commands\Rapat\DataRapatCommand::class,
            \App\Console\Commands\Bendahara\PengingatPembayaranSiswaCommand::class,
            \App\Console\Commands\System\RessetAndReseed::class,
            \App\Console\Commands\System\BersihkanTemp::class,
            \App\Console\Commands\Bendahara\BendaharaKomitecommand::class,
            \App\Console\Commands\Bendahara\BendaharaBoscommand::class,
            \App\Console\Commands\Ekstra\Ekstracommand::class,
            \App\Console\Commands\CBT\JadwalCbtcommand::class,
            \App\Console\Commands\CBT\JadwalPengingatUlanganCommand::class,
            \App\Console\Commands\Perpustakaan\PengembalianBukuPerpustakaanCommand::class,
            \App\Console\Commands\PPDB\Ppdbcommand::class,
            \App\Console\Commands\Bendahara\Tabungan\TabunganSiswaCommand::class,
            \App\Console\Commands\Tahfidz\Tahfidzcommand::class,
            \App\Console\Commands\Ekstra\PengingatEkstracommand::class, //
            \App\Console\Commands\Tahfidz\TahfidzCommand::class,
            \App\Console\Commands\ShalatBerjamaah\ShalatBerjamaahCommand::class,
            \App\Console\Commands\Absensi\RekapAbsensiSiswaBulananCommand::class,
            \App\Console\Commands\Whatsapp\ValidasiKontakCommand::class,
            \App\Console\Commands\System\CekRegistrasiCommand::class,
            \App\Console\Commands\System\SynGitHubClientCommand::class,



        ]);
    }

    /**
     * Bootstrap services.
     * php artisan schedule:work
     * php artisan schedule:list
     * php artisan schedule:run
     * Gunakan ->runInBackground() untuk proses banyak data jadi tetap lanjut
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $Identitas = Identitas::first();
            if (!$Identitas) {
                return; // kalau belum ada data identitas, skip
            }

            $schedule->command('maintenance:clear-all')
                ->dailyAt('08:15')
                ->withoutOverlapping()
                ->appendOutputTo(storage_path('logs/clear_all_cache.log'));

            switch ($Identitas->paket) {
                case 'Gratis':
                    // jalankan logika khusus offline
                    break;
                case 'Kerjasama':
                    // Ekstra
                    //

                    // Shalat Berjamaah
                    // jalankan logika khusus kerjasama
                    break;


                case 'Premium':
                    // Perpustakaan
                    $schedule->command('siakad:pengembalian-buku-perpustakaan')->dailyAt('09:30')->runInBackground(); // Chat ke semua peminjam buku agar besok pagi segera dikembalikan
                    // Tabungan setiap akhir bulan
                    $schedule->command('tabungan:tabungan-siswa')
                        ->dailyAt('09:00')
                        ->when(function () {
                            return now()->isLastOfMonth();
                        });
                    $schedule->command('rapat:data-rapat')->dailyAt('07:30')->runInBackground(); // Chat ke semua peminjam buku agar besok pagi segera dikembalikan
                    // \Log::info('Mode Premium aktif');
                    // jalankan logika khusus premium
                    break;

                default:
                    // \Log::warning("Paket {$Identitas->paket} tidak dikenali");
            }

            // $schedule->command('siakad:cobabuat')->everyFiveMinutes(); // KirimJadwalWhatsapp Bagian Internal
            // $schedule->command('siakad:cobabuat')->everyMinute(); // KirimJadwalWhatsapp Bagian Internal
            /*
                |--------------------------------------------------------------------------
                | 📌 Jadwal Whatsapp :
                |--------------------------------------------------------------------------
                |
                | Fitur :
                | - Mengirim pesan sesuai jadwal pengiriman didalam internal sekolah sebagai pengingat harian
                |
                | Tujuan :
                | - Meningkatkan ketepatan waktu dalam melaksanakan agenda kegiatan
                |
                |
                |
            */
            // Proses Coding
            $schedule->command('wa:PenjadwalanPesan')->everyMinute(); // KirimJadwalWhatsapp Bagian Internal

            // $schedule->command('wa:PenjadwalanPesan')->everyMinute()->runInBackground(); // KirimJadwalWhatsapp Bagian Internal
            /*
                |--------------------------------------------------------------------------
                | 📌 Absensi :
                |--------------------------------------------------------------------------
                |
                | Fitur :
                | - Auto Alfa tidak ada absen pukul 08:000
                | - Rekap dan Laporan Absen Siswa untuk kepala
                | - Rekap dan Laporan Absen Siswa perkelas untuk wali kelas : absen:rekap-absen
                |
                | Tujuan :
                | - Meringankan tugas guru piket
                | - Meningkatkan kerjasama wali kelas dengan laporan penyediaan data absensi
                |
            */
            // Proses Coding
            if (!is_day('minggu')) {
                $schedule->command('ekstra:pengingat-ekstra')->dailyAt('09:30'); // PengingatEkstracommand
                // CekAbsenKosongSiswa
                $schedule->command('siakad:CekAbsenKosongSiswa')->dailyAt('08:30')->runInBackground(); // CekAbsenKosong
                $schedule->command('siakad:CekAbsenKosongSiswa')->dailyAt('13:45')->runInBackground(); // CekAbsenKosong
                // CekPengirimanWaAbsensiCommand
                $schedule->command('whatsapp:cek-wa-absensi-null')->hourly(); // Pengecekan kirim wa saat wa absensi bermasalah dicek setiap jam akan dikirim ulang
                // LaporanAbsensiGuruCommand
                $schedule->command('laporan:absensi-guru')->dailyAt('09:00')->runInBackground(); // Kirim laporan absensi ke kepala : LaporanAbsensiGuruCommand
            }
            // CekRegistrasiCommand
            $schedule->command('system:cek-registrasi')->dailyAt('08:30'); // Pengecekan registrasi sebagai pengingat
            // $schedule->command('absen:rekap-absen')->dailyAt('08:30')->runInBackground(); //Rekap Absen untuk laporan
            /*
                |--------------------------------------------------------------------------
                | 📌 Perpustakaan :
                |--------------------------------------------------------------------------
                |
                | Fitur :
                | - Pengingat pengembalian buku ke siswa 1 hari sebelumnya
                | - xxxxxxxxxxx
                |
                | Tujuan :
                | - Penertiban pengembalian buku ke siswa
            */

            /*
                |--------------------------------------------------------------------------
                | 📌 Pembayaran Siswa : Dilakukan setiap tanggal 2
                |--------------------------------------------------------------------------
                |
                | Fitur Kerjasama :
                | - Pengingat Pembayaran Bulanan Sasaran Ortu Siswa
                |
                | Full Version :
                | - Pengingat Pembayaran Bulanan Sasaran Ortu Siswa
                | - Rekap Pembayaran
                |
                | Tujuan :
                | - Penertiban pembayaran siswa agar terjadinya kestabilan anggaran
                |
            */

            // $schedule->command('siakad:pengingat-pembayaran-siswa')->monthlyOn(2, '09:30')->runInBackground();
            // Pengingat Pembayaran
            // PengingatPembayaranSiswaCommand
            $schedule->command('siakad:pengingat-pembayaran-siswa')
                ->when(function () {
                    $now = \Carbon\Carbon::now();

                    // cek kalau hari ini tanggal 2 dan bukan Minggu
                    if ($now->day === 2 && $now->isSunday() === false) {
                        return true;
                    }

                    // cek kalau hari ini tanggal 3 dan kemarin adalah Minggu tanggal 2
                    if ($now->day === 3 && $now->copy()->subDay()->day === 2 && $now->copy()->subDay()->isSunday()) {
                        return true;
                    }

                    return false;
                })
                ->at('09:30')
                ->runInBackground();

            // RekapAbsensiSiswaBulananCommand
            $schedule->command('absensi:rekap-bulanan')
                ->when(function () {
                    $now = \Carbon\Carbon::now();

                    // tanggal terakhir bulan ini
                    $lastDayOfMonth = $now->copy()->endOfMonth();

                    // kondisi 1: hari ini adalah tanggal terakhir bulan & bukan Minggu
                    if ($now->isSameDay($lastDayOfMonth) && !$now->isSunday()) {
                        return true;
                    }

                    // kondisi 2: hari terakhir bulan jatuh Minggu → jalankan H-1
                    if ($now->isSameDay($lastDayOfMonth->copy()->subDay()) && $lastDayOfMonth->isSunday()) {
                        return true;
                    }

                    return false;
                })
                ->at('09:30')
                ->runInBackground();

            // Shalat Berjamaah
            /*
                |--------------------------------------------------------------------------
                | 📌 Shalat Berjamaah :
                |--------------------------------------------------------------------------
                |
                | Fitur :
                | - Pengingat Shalat Berjamaah 1 Hari sebelumnya ke siswa + Imam
                | - xxxxxxxxxxx
                |
                | Tujuan :
                | - Mengingatkan siswa membawa perlengkapan shalat
                |
                |
                | Penggunaan :
                | - xxxxxxxxxxx
                |
                */
            // Proses Coding

            /*
                |--------------------------------------------------------------------------
                | 📌 BackUpDatabase :
                |--------------------------------------------------------------------------
                |
                | Fitur :
                | - Backup otomatis database untuk menghindari terjadi sesuatu yang tidak di inginkan
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
            $schedule->command('backup:database')->dailyAt('08:00'); //BackupDatabase
            $schedule->command('update:SynGitHub')->weeklyOn(3, '11:00'); // Update Github


        });

        //$schedule->command('maintenance:clear-all')->everyMinute();
    }
}
/*
Untuk hari sabtu
$schedule->command('namaCommand')->weekly()->saturdays();
$schedule->command('namaCommand')->weeklyOn(6, '14:00'); // 6 = Sabtu, jam 14:00
*/
