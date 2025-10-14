<?php

namespace App\Console\Commands\System;

use Carbon\Carbon;
use App\Models\Admin\Identitas;
use Illuminate\Console\Command;
use App\Models\Whatsapp\WhatsApp;

class InfonShutdownPCCommand extends Command
{
    protected $signature = 'info:shutdown';
    protected $description = 'Memberikan informasi sebelum shutdown PC';

    public function handle()
    {

        $waData = [
            // config('whatsappSession.NoKepala'),
            config('whatsappSession.DevNomorTujuan')
        ];
        $Identitas = Identitas::first();

        $hari = Carbon::create(now())->translatedformat('l, d F Y');
        $jam = Carbon::create(now())->translatedformat('H:i');
        $sessions = config('whatsappSession.IdWaUtama');
        $PesanKirim =
            "📦 *Informasi Shutdown*\n" .
            "🗓️ Hari ini {$hari}, proses Shutdown telah dijalankan.\n\n" .
            "📄 Jam     : {$jam}\n" .
            "\n✅ Komputer Sever {$Identitas->namasek} Telah dimatikan \n" .
            "\n\n*Catatan:*\nFitur ini sebagai pencegahan adanya masalah database!!!\n" .
            "\n\n";
        foreach ($waData as $kirikke):
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $kirikke, format_pesan('Informasi Backup Database', $PesanKirim));
        endforeach;
        // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $PesanKirim);
        $this->info("Command 'InfonShutdownPCCommand' berhasil dijalankan.");
    }
}
