<?php

namespace App\Console\Commands\System;

use App\Models\AdminDev\Modul;
use Illuminate\Console\Command;

class AktivasiModulCommand extends Command
{
    protected $signature = 'System:aktivasi-modul';
    protected $description = 'Mengaktifkan atau non aktifkan modul';

    public function handle()
    {
        // $modul = Modul::where()
        $this->info("Command 'AktivasiModulCommand' berhasil dijalankan.");
    }
}
