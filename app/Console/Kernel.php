<?php

namespace App\Console;
// app\Kernel.php
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\ClearAllCache::class,
        // \App\Console\Commands\MakeHelper::class,
        \App\Console\Commands\DbSeedCommand::class, // ← Tambahkan baris ini
        // \App\Console\Commands\JadwalWhatsapp::class,
        \App\Console\Commands\Cobabuat::class,
        // \App\Console\Commands\JadwalPengingatUlangan::class,
        \App\Console\Commands\WhatsappBulanan::class,
        \App\Console\Commands\RessetAndReseed::class,
        \App\Console\Commands\WhatsappSessionCek::class,
        \App\Console\Commands\BersihkanTemp::class,
        \App\Console\Commands\TabunganSiswaCommand::class,
        \App\Console\Commands\BendaharaKomitecommand::class,
        \App\Console\Commands\BendaharaBoscommand::class,
        \App\Console\Commands\JadwalCbtcommand::class,
        \App\Console\Commands\Ekstracommand::class,
        \App\Console\Commands\Ppdbcommand::class,
        \App\Console\Commands\Tahfidzcommand::class,
        // \App\Console\Commands\ServerAktif::class,
        \App\Console\Commands\PengingatEkstracommand::class,
        \App\Console\Commands\TahfidzCommand::class,
        \App\Console\Commands\ShalatBerjamaahCommand::class,
    
        \App\Console\Commands\RekapAbsensiBulananCommands::class,

        \App\Console\Commands\Absensi.RekapAbsensiBulananCommands::class,

        \App\Console\Commands\SyncCommand::class,

        \App\Console\Commands\User\SyncCommand::class,

        \App\Console\Commands\Absensi\RekapBulananCommand::class,
];


    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }

    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->command('wa:PenjadwalanPesan')->everyMinute(); // atau sesuai kebutuhan
    // }
}
