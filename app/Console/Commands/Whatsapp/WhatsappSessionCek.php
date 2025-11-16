<?php

namespace App\Console\Commands\Whatsapp;

use Illuminate\Console\Command;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\Http;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Whatsapp\WhatsAppSession;

class WhatsappSessionCek extends Command
{
    protected $signature = 'siakad:KirimSesiWhatsapp';
    protected $description = 'Mengecek Sesi Whatsapp setiap satu jam sekali dan jalankan jika sesi tidak aktif, jika aktif abaikan';

    /*
        |--------------------------------------------------------------------------
        | 📌 WhatsappSession
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | -
        |
        | Tujuan :
        | - Agar whatsapp stabil dalam digunakan cek sesi untuk menghindari sesi whatsapp mati!
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
        $sessions = WhatsAppSession::all();
        $results = [];
        $offlineSessions = [];

        foreach ($sessions as $session) {
            try {
                $response = Http::timeout(2)->get("http://localhost:3000/status/{$session->akun_id}");
                $statusLive = $response->json()['status'] ?? 'not connected';
            } catch (\Exception $e) {
                $statusLive = 'not connected';
            }

            $keterangan = $statusLive === 'connected' ? 'tidak perlu scan QR' : 'perlu scan QR';

            $results[] = [
                'akun_id' => $session->akun_id,
                'status' => $statusLive,
                'keterangan' => $keterangan
            ];

            if ($statusLive !== 'connected') {
                $offlineSessions[] = $session->akun_id;
            }
        }

        // Ambil satu sesi pengirim yang aktif
        $sesiPengirim = collect($results)->firstWhere('status', 'connected');

        if ($sesiPengirim) {
            $this->info("Sesi pengirim: {$sesiPengirim['akun_id']} siap digunakan.");

            $NoTujuan = config('whatsappSession.WhatsappDev')
                ? config('whatsappSession.DevNomorTujuan')
                : config('whatsappSession.SekolahNoTujuan');

            // Buat pesan gabungan semua sesi
            $PesanKirim = "";
            $PesanKirim .= "Berikut informasi status akun whatsapp\n";
            foreach ($results as $r) {
                $PesanKirim .= "- {$r['akun_id']} : {$r['status']} → {$r['keterangan']}\n";
            }

            // Kirim pesan ke admin/dev
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage(
                $sesiPengirim['akun_id'],
                $NoTujuan,
                format_pesan("Informasi Akun Whatsapp", $PesanKirim)

            );

            $this->info("Pesan berhasil dikirim.");

            // Opsional: highlight sesi offline saja
            if (!empty($offlineSessions)) {
                $PesanOffline = "⚠️ Sesi WA tidak aktif: " . implode(", ", $offlineSessions);
                \App\Models\Whatsapp\WhatsApp::sendMessage(
                    $sesiPengirim['akun_id'],
                    $NoTujuan,
                    format_pesan("Informasi Akun Whatsapp", $PesanOffline)
                );
                $this->warn($PesanOffline);
            }
        } else {
            $this->warn("Tidak ada sesi aktif, tidak bisa mengirim pesan.");
        }
    }
}
