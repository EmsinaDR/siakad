<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class PormosiCommandCommand extends Command
{
    protected $signature = 'siakad:promosi';
    protected $description = 'Promosi siakad dengan array no hp';

    public function handle()
    {
        $noHps = [];
        $gambar = true;
        $sessions = config('whatsappSession.IdWaUtama');
        foreach ($noHps as $nohp):
            $pesan =
                "isi pesan\n" .
                "isi pesan\n" .
                "\n\n";
            if ($gambar === 1) {
                $filename = 'contoh.jpg';
                $filePath = base_path('whatsapp/uploads/' . $filename);
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $nohp, $pesan, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
            } else {
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $nohp, format_pesan('judul', $pesan));
            }
        endforeach;
        $this->info("Command 'PormosiCommandCommand' berhasil dijalankan.");
    }
}
