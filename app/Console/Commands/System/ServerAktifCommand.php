<?php

namespace App\Console\Commands\System;

use App\Models\Admin\Identitas;
use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\User\Siswa\Detailsiswa;

class ServerAktifCommand extends Command
{
    protected $signature = 'start:ServerAktif';
    protected $description = 'Proses aktifkan server';

    /*
        |--------------------------------------------------------------------------
        | 📌 WhatsApp
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - Informasi server aktif pada saat restart
        |
        | Tujuan :
        | - Jelaskan tujuan command ini
        | -
        |
        |
        | Penggunaan :
        | - Jelaskan penggunaannya dimana atau hubungannya
        | -
        |
        |
        |
    */

    public function handle()
    {
        // Tuliskan logika command di sini
        $Identitas = Identitas::first();
        $url = 'http://127.0.0.1:3000/send-message';
        $sessions = config('whatsappSession.IdWaUtama');
        if (!config('whatsappSession.WhatsappDev')) {
            $NoTujuan = $Identitas->phone;
        } else {
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        $hari = Carbon::create(now())->translatedformat('l, d F Y');
        $jam = Carbon::create(now())->translatedformat('H:i');
        $sessions = config('whatsappSession.IdWaUtama');
        $NoTujuan = config('whatsappSession.DevNomorTujuan');
        $pesanKiriman =
            "==============================\n" .
            "📌 *Informasi Server :*\n" .
            "==============================\n\n" .
            "*Server telah aktif!*\n" .
            "🗓 Hari & Tanggal\t: {$hari}\n" .
            "⏰ Jam\t\t\t\t\t\t\t\t: {$jam} WIB\n" .
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";
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
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $kirikke, format_pesan('Informasi Backup Database', $pesanKiriman));
        endforeach;
        // $response = Http::timeout(3)->post($url, [
        //     'id'      => $sessions,
        //     'number'  => $NoTujuan,
        //     'message' => $pesanKiriman,
        // ]);
        $this->info("Command 'ServerAktif' berhasil dijalankan.");
    }
}
