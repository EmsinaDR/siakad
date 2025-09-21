<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class SynGitHubCommand extends Command
{
    protected $signature = 'update:SynGitHub';
    protected $description = 'Sinkron kode dari GitHub ke local (cek update dulu, pull jika ada)';

    public function handle()
    {
        $this->info("Mulai sinkron GitHub...");
        $sessions = config('whatsappSession.IdWaUtama');
        $NoRequest = config('whatsappSession.IdWaUtama');
        $pesan =
            "System update otomatisa telah dijalankan";
        $update =
            [
                "executor\whatsapp\update.exe",
                "executor\siakad\update.exe"
            ];
        foreach ($update as $stack):
            $result = run_bat($stack);
        endforeach;

        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
    }
}
