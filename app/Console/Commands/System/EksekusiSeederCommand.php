<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class EksekusiSeederCommand extends Command
{
    protected $signature = 'Sync:EksekusiSeeder';
    protected $description = 'Control file seeder jika ada di jalankan otomatis';

    // public function handle()
    // {
    //     $files = glob(base_path('database/seeders/*.php'));

    //     if (!empty($files)) {
    //         $this->info('Ada file seeder .php di folder database/seeders');
    //     } else {
    //         $this->info('Tidak ada file seeder .php di folder database/seeders');
    //     }

    //     $this->info("Command 'EksekusiSeederCommand' berhasil dijalankan.");
    // }
    public function handle()
    {
        // Ambil semua file .php langsung di folder seeders
        $files = glob(database_path('seeders/*.php'));

        if (empty($files)) {
            $this->info('Tidak ada file seeder .php di folder database/seeders');
            return 0;
        }

        $this->info('Menjalankan seeder yang ditemukan:');

        foreach ($files as $file) {
            $className = pathinfo($file, PATHINFO_FILENAME);
            $this->info("-> Menjalankan: $className");

            $this->call('db:seed', [
                '--class' => $className,
                '--force' => true, // optional untuk production
            ]);
        }

        $this->info("✅ Semua seeder selesai dijalankan!");
    }
}
