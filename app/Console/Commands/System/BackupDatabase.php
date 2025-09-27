<?php

namespace App\Console\Commands\System;

use Carbon\Carbon;
use Illuminate\Support\Number;
use Illuminate\Console\Command;
use App\Models\Whatsapp\WhatsApp;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup database ke file SQL setiap jam';

    public function handle()
    {

        $identitas = getIdentitas();
        $filename = 'backup-' . strtolower(str_replace(' ', '', $identitas->namasingkat)) . '-' . now()->format('Ymd-His') . '.sql';
        $directory = storage_path('backups/sql');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        $path = $directory . '/' . $filename;
        $db   = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');

        $mysqldump = 'C:\\laragon\\bin\\mysql\\mysql-8.3.0-winx64\\bin\\mysqldump.exe';

        // Password kosong → tidak pakai -p
        $passwordPart = $pass ? '-p' . escapeshellarg($pass) : '';

        $command = sprintf(
            '%s -u%s %s -h%s %s > %s',
            $mysqldump,
            escapeshellarg($user),
            $passwordPart,
            escapeshellarg($host),
            escapeshellarg($db),
            escapeshellarg($path)
        );

        $output = null;
        $status = null;
        exec($command, $output, $status);
        if ($status === 0 && file_exists($path)) {
            $size = filesize($path); // ukuran file dalam byte
            $this->info("✅ Backup berhasil: $filename (Ukuran: {$size} bytes)");
        } else {
            $this->error("❌ Backup gagal. Periksa apakah `mysqldump` tersedia dan kredensial benar.");
        }
        $sizeMB = Number::forHumans($size / 1024 / 1024);;
        $hari = Carbon::create(now())->translatedformat('l, d F Y');
        if (!config('whatsappSession.WhatsappDev')) {
            $waData = [
                config('whatsappSession.NoKepala'),
                config('whatsappSession.DevNomorTujuan')
            ];
        } else {
            $waData = [
                config('whatsappSession.DevNomorTujuan')
            ];
        }

        $sessions = config('whatsappSession.IdWaUtama');
        $PesanKirim =
            "📦 *Informasi Backup Database*\n" .
            "🗓️ Hari ini {$hari}, proses Backup Database telah dijalankan.\n\n" .
            "📄 Nama File      : {$filename}\n" .
            "📏 Ukuran File    : {$sizeMB} MB\n" .
            "💾 Penyimpanan    : storage/backups/sql\n" .
            "\n✅ Backup selesai dengan sukses!\n" .
            "\n\n*Catatan:*\nFitur ini sebagai pencegahan adanya masalah database!!!\n" .
            "\n\n";
        foreach ($waData as $kirikke):
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $kirikke, format_pesan('Informasi Backup Database', $PesanKirim));
        endforeach;
    }
}
