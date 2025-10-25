<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class ClearLog extends Command
{
    protected $signature = 'clear:log';
    protected $description = 'Bersihin semua Laravel log di storage/logs.';

    public function handle()
    {
        $logPath = storage_path('logs/laravel.log');

        if (file_exists($logPath)) {
            file_put_contents($logPath, '');
            $this->info('Log Laravel berhasil dibersihkan! 🧹');
        } else {
            $this->warn('Log file tidak ditemukan.');
        }
    }
}
// php artisan clear:log
