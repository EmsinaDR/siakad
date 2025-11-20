<?php

namespace App\Console\Commands\System;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Whatsapp\WhatsApp;

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

        $hari = Carbon::create(now())->translatedformat('l, d F Y');
        $jam = Carbon::create(now())->translatedformat('H:i');
        $pesanKiriman =
            "*Cek Update Telah Selesai!*\n" .
            "🗓 Hari & Tanggal\t: {$hari}\n" .
            "⏰ Jam\t\t\t\t\t\t\t\t: {$jam} WIB\n";

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

        foreach ($waData as $kirikke):
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $kirikke, format_pesan('Informasi Update Server', $pesanKiriman));
        endforeach;

        // $result = \App\Models\Whatsapp\WhatsApp::sendMessage(
        //     $sessions,
        //     $NoRequest,
        //     format_pesan('Data Vendor', $pesan)
        // );
    }
}
