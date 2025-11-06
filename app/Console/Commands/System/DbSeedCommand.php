<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DbSeedCommand extends Command
{
    protected $signature = 'dbseed'; // Nama perintah
    protected $description = 'Menjalankan migrate:fresh dan seeder dengan cukup php artisan dbseed';

    public function handle()
    {
        $this->info('Menghapus dan mengisi ulang database...');
        Artisan::call('migrate:fresh --seed');
        $this->info(Artisan::output());
    }
}
