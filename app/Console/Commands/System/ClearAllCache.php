<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearAllCache extends Command
{
    protected $signature = 'siakad:clear';
    protected $description = 'Membersihkan semua cache (config, route, view, cache) dengan gaya keren.';

    public function handle()
    {
        $this->info('Mulai bersih-bersih cache... 🧹');

        Artisan::call('cache:clear');
        $this->info('Cache application dibersihkan.');

        Artisan::call('route:clear');
        $this->info('Route cache dibersihkan.');

        Artisan::call('config:clear');
        $this->info('Config cache dibersihkan.');

        Artisan::call('view:clear');
        $this->info('View cache dibersihkan.');

        $this->info('Semua bersih! Aplikasi fresh seperti baru install 😎');
        $file = 'executor\\pc\\cleaner-file.bat';
        run_bating($file);
        $this->info('Folder Temp Semua telah dibersihkan');
    }
}
// php artisan clear:clear-all
