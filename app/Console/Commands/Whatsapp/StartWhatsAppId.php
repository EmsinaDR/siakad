<?php

namespace App\Console\Commands\Whatsapp;


use App\Models\Whatsapp\WhatsAppSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class StartWhatsAppId extends Command
{
    protected $signature = 'start:wa-sessions';
    protected $description = 'Trigger WA session start untuk semua akun dari database';

    public function handle()
    {
        // Menjalankan sesi berdasarkan di database dan harus dijalankan melalui startup bat / shceduler


        // if (empty($sessions)) {
        //     $this->warn("Tidak ada session WA yang ditemukan di database.");
        //     return;
        // }
        // $sessions = [config('whatsappSession.IdWaUtama')];
        if (!config('whatsappSession.WhatsappDev')) {
            $sessions = WhatsAppSession::pluck('akun_id')->toArray();
        } else {
            $sessions = [config('whatsappSession.IdWaUtama')];
        }

        // dd($sessions);
        foreach ($sessions as $sessionId) {
            try {
                $response = Http::post('http://localhost:3000/start-session', [
                    'id' => $sessionId,
                ]);

                $this->info("[$sessionId] => " . $response->body());
            } catch (\Exception $e) {
                $this->error("[$sessionId] GAGAL: " . $e->getMessage());
            }
        }
    }
}
