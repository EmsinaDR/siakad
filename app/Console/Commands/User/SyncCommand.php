<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

class SyncCommand extends Command
{
    protected $signature = 'sync:user';
    protected $description = 'Sinkronisasi User';

    /*
        |----------------------------------------------------------------------
        | 📌 MyApp
        |----------------------------------------------------------------------
        | Jelaskan tujuan dan contoh schedule di sini
        |
    */

    public function handle()
    {
        // Tuliskan logika command di sini
        $this->info("Command 'SyncCommand' berhasil dijalankan.");
    }
}