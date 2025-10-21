<?php

namespace App\Console\Commands\Tahfidz;

use App\Models\Program\Tahfidz\RiwayatHafalanTahfidz;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class TahfidzCommand extends Command
{
    protected $signature = 'program:tahfidz-command';
    protected $description = 'Pengelola informasi tahfidz';

    /*
        |--------------------------------------------------------------------------
        | 📌 Tahfidz
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | -
        |
        | Tujuan :
        | - Jelaskan tujuan command ini
        | ScheduleServiceProvider :
        | $schedule->command('program:tahfidz-command')->everyMinute();               // Setiap menit dijalankan
        | $schedule->command('program:tahfidz-command')->everyTwoMinutes();           // Setiap 2 menit dijalankan
        | $schedule->command('program:tahfidz-command')->everyThreeMinutes();         // Setiap 3 menit dijalankan
        | $schedule->command('program:tahfidz-command')->everyFiveMinutes();          // Setiap 5 menit dijalankan
        | $schedule->command('program:tahfidz-command')->everyTenMinutes();           // Setiap 10 menit dijalankan
        | $schedule->command('program:tahfidz-command')->everyFifteenMinutes();       // Setiap 15 menit dijalankan
        | $schedule->command('program:tahfidz-command')->everyThirtyMinutes();        // Setiap 30 menit dijalankan
        | $schedule->command('program:tahfidz-command')->hourly();                    // Setiap jam dijalankan
        | $schedule->command('program:tahfidz-command')->hourlyAt(15);                // Setiap jam, tepat di menit ke-15
        | $schedule->command('program:tahfidz-command')->daily();                     // Setiap hari pukul 00:00
        | $schedule->command('program:tahfidz-command')->dailyAt('07:30');            // Setiap hari pukul 07:30
        | $schedule->command('program:tahfidz-command')->twiceDaily(1, 13);           // Setiap hari pukul 01:00 dan 13:00
        | $schedule->command('program:tahfidz-command')->weekly();                    // Setiap minggu pada Senin pukul 00:00
        | $schedule->command('program:tahfidz-command')->weeklyOn(1, '08:00');        // Setiap minggu pada hari Senin pukul 08:00
        | $schedule->command('program:tahfidz-command')->monthly();                   // Setiap bulan tanggal 1 pukul 00:00
        | $schedule->command('program:tahfidz-command')->monthlyOn(15, '09:00');      // Setiap bulan tanggal 15 pukul 09:00
        | $schedule->command('program:tahfidz-command')->quarterly();                 // Setiap 3 bulan
        | $schedule->command('program:tahfidz-command')->yearly();                    // Setiap tahun pada 1 Januari pukul 00:00
        | $schedule->command('program:tahfidz-command')->timezone('Asia/Jakarta');    // Menentukan timezone
        | $schedule->command('program:tahfidz-command')->runInBackground();           // Menjalankan command di background
        | $schedule->command('program:tahfidz-command')->withoutOverlapping();        // Mencegah command berjalan bersamaan
        | $schedule->command('program:tahfidz-command')->onOneServer();               // Menjalankan hanya di satu server
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
        // Tuliskan logika command di sini
        $tapel = tapel();
        $TahfidzRiwayat = RiwayatHafalanTahfidz::pluck('detailsiswa_id')->toArray();
        if (!config('whatsappSession.WhatsappDev')) {
            $Siswa = getSiswaByIds($TahfidzRiwayat);
        } else {
            $Siswa = getSiswaByIds($TahfidzRiwayat, 5);
        }
        // dd($Siswa);
        foreach ($Siswa as $peserta) {
            if (!config('whatsappSession.WhatsappDev')) {
                //$sessions = getWaSessionByTingkat($Siswa->tingkat_id);
                //$sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = $peserta->no_hp;
            } else {
                $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            $message = format_pesan("Data Riwayat Tahfidz", riwayat_tahfidz($peserta));
            $kirimMedia = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $message);
        }
        $this->info("Command 'TahfidzCommand' berhasil dijalankan.");
    }
}
