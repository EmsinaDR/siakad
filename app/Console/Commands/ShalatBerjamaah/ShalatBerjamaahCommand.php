<?php

namespace App\Console\Commands\ShalatBerjamaah;

use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class ShalatBerjamaahCommand extends Command
{
    protected $signature = 'program:shalat-berjamaah';
    protected $description = 'Untuk mengelola jadwal shalat berjamaah dan informasi terkait shalat berjamaah';

    /*
        |--------------------------------------------------------------------------
        | 📌 ShalatBerjamaah
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | -
        |
        | Tujuan :
        | - Jelaskan tujuan command ini
        | ScheduleServiceProvider :
        | $schedule->command('program:shalat-berjamaah')->everyMinute();               // Setiap menit dijalankan
        | $schedule->command('program:shalat-berjamaah')->everyTwoMinutes();           // Setiap 2 menit dijalankan
        | $schedule->command('program:shalat-berjamaah')->everyThreeMinutes();         // Setiap 3 menit dijalankan
        | $schedule->command('program:shalat-berjamaah')->everyFiveMinutes();          // Setiap 5 menit dijalankan
        | $schedule->command('program:shalat-berjamaah')->everyTenMinutes();           // Setiap 10 menit dijalankan
        | $schedule->command('program:shalat-berjamaah')->everyFifteenMinutes();       // Setiap 15 menit dijalankan
        | $schedule->command('program:shalat-berjamaah')->everyThirtyMinutes();        // Setiap 30 menit dijalankan
        | $schedule->command('program:shalat-berjamaah')->hourly();                    // Setiap jam dijalankan
        | $schedule->command('program:shalat-berjamaah')->hourlyAt(15);                // Setiap jam, tepat di menit ke-15
        | $schedule->command('program:shalat-berjamaah')->daily();                     // Setiap hari pukul 00:00
        | $schedule->command('program:shalat-berjamaah')->dailyAt('07:30');            // Setiap hari pukul 07:30
        | $schedule->command('program:shalat-berjamaah')->twiceDaily(1, 13);           // Setiap hari pukul 01:00 dan 13:00
        | $schedule->command('program:shalat-berjamaah')->weekly();                    // Setiap minggu pada Senin pukul 00:00
        | $schedule->command('program:shalat-berjamaah')->weeklyOn(1, '08:00');        // Setiap minggu pada hari Senin pukul 08:00
        | $schedule->command('program:shalat-berjamaah')->monthly();                   // Setiap bulan tanggal 1 pukul 00:00
        | $schedule->command('program:shalat-berjamaah')->monthlyOn(15, '09:00');      // Setiap bulan tanggal 15 pukul 09:00
        | $schedule->command('program:shalat-berjamaah')->quarterly();                 // Setiap 3 bulan
        | $schedule->command('program:shalat-berjamaah')->yearly();                    // Setiap tahun pada 1 Januari pukul 00:00
        | $schedule->command('program:shalat-berjamaah')->timezone('Asia/Jakarta');    // Menentukan timezone
        | $schedule->command('program:shalat-berjamaah')->runInBackground();           // Menjalankan command di background
        | $schedule->command('program:shalat-berjamaah')->withoutOverlapping();        // Mencegah command berjalan bersamaan
        | $schedule->command('program:shalat-berjamaah')->onOneServer();               // Menjalankan hanya di satu server
        |
        | Penggunaan :
        | - Jelaskan penggunaannya dimana atau hubungannya
        | -
        |
    */

    public function handle()
    {
        // Tuliskan logika command di sini
        $this->info("Command 'ShalatBerjamaahCommand' berhasil dijalankan.");
    }
}