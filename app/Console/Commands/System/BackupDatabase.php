<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup database ke file SQL setiap jam';

    public function handle()
    {
        $filename = 'backup-' . now()->format('Ymd-His') . '.sql';
        $directory = storage_path('backups/sql');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory . '/' . $filename;

        $db   = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');

        // Hindari password bocor di command line log (gunakan format ini)
        $command = sprintf(
            'mysqldump -u%s -p"%s" -h%s %s > %s',
            escapeshellarg($user),
            escapeshellarg($pass),
            escapeshellarg($host),
            escapeshellarg($db),
            escapeshellarg($path)
        );

        $status = null;
        $output = null;
        exec($command, $output, $status);

        if ($status === 0 && file_exists($path)) {
            $this->info("✅ Backup berhasil: $filename");
        } else {
            $this->error("❌ Backup gagal. Periksa apakah `mysqldump` tersedia dan kredensial benar.");
        }
    }
}
