<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class SynGitHubClientCommand extends Command
{
    protected $signature = 'update:SynGitHub';
    protected $description = 'Sinkron kode dari GitHub ke local (cek update dulu, pull jika ada)';

    public function handle()
    {
        $this->info("Mulai sinkron GitHub...");

        $sessions = config('whatsappSession.IdWaUtama');
        $NoRequest = config('whatsappSession.IdWaUtama');
        $pesan = "System update otomatis telah dijalankan";

        $update = [
            "executor\\whatsapp\\update.exe",
            "executor\\siakad\\update.exe"
        ];

        foreach ($update as $stack) {
            $result = run_bat($stack);
        }

        $result = \App\Models\Whatsapp\WhatsApp::sendMessage(
            $sessions,
            $NoRequest,
            format_pesan('Data Vendor', $pesan)
        );
    }
}
