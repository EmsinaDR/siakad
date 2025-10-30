<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class EksekusiMiggrationComman extends Command
{
    protected $signature = 'Sinc:EksekusiMigration';
    protected $description = 'Menjalankan migrasi yang tersedia';

    public function handle()
    {
        $this->info("Command 'EksekusiMiggrationCommandCommand' berhasil dijalankan.");
    }
}