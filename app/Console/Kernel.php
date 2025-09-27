<?php

namespace App\Console;
// app\Kernel.php
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // \App\Console\Commands\JadwalWhatsapp::class,
        \App\Console\Commands\Cobabuat::class,
        // \App\Console\Commands\JadwalPengingatUlangan::class,

        \App\Console\Commands\SyncCommand::class,

        \App\Console\Commands\User\SyncCommand::class,


        \App\Console\Commands\Absensi\LaporanAbsensiGuruCommand::class,
        \App\Console\Commands\System\SynGitHubCommand::class,
        \App\Console\Commands\Whatsapp\CekPengirimanWaAbsensiCommand::class,
        \App\Console\Commands\Ucapan\UlanganTahunCommandCommand::class,

    \n        \App\Console\Commands\System\ControlPCCommand::class,\n\n        \App\Console\Commands\System\CekRegistrasiCommand::class,\n\n        \App\Console\Commands\System\UpdateSiakadCommand::class,\n\n        \App\Console\Commands\System\EksekusiSeederCommand::class,\n\n        \App\Console\Commands\System\EksekusiMiggrationCommandCommand::class,\n\n        \App\Console\Commands\Whatsapp\CekSessionQrcodeCommand::class,\n\n        \App\Console\Commands\System\AktivasiModulCommand::class,\n\n        \App\Console\Commands\Absensi\CekAlfaCommand::class,\n\n        \App\Console\Commands\System\InfonShutdownPCCommand::class,\n];


    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }

    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->command('wa:PenjadwalanPesan')->everyMinute(); // atau sesuai kebutuhan
    // }
}
