<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 Auto_reply_alumni :
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - xxxxxxxxxxx
        | - xxxxxxxxxxx
        |
        | Tujuan :
        | - xxxxxxxxxxx
        |
        | Penggunaan :
        | - xxxxxxxxxxx
        |
    */

// Proses Coding
if (!function_exists('Auto_reply_alumni')) {
    function Auto_reply_alumni($Kode, $NoRequest, $message)
    {
        // TODO: Implement your helper logic here
        // Kode / Alumni / kode guru /
        $pesan = explode('/', $message);
        $kodeGuru = $pesan[2];
        $Guru = Detailguru::where('kode_guru', $kodeGuru)->first();
        if (!config('whatsappSession.WhatsappDev')) {
            //$sessions = getWaSession(siswa->tingkat_id); // by tingkat ada di dalamnya
            $sessions = config('whatsappSession.IdWaUtama');
            //NoTujuan = getNoTujuanOrtu(siswa)
            // $NoTujuan = $NoRequest;
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        switch ($Kode) {
            case 'Data Alumni': //Data Alumni/Alumni/tahun_lulus
                // Log::info("Request received: Number - $number, Nis - $nis dan Kode = $Kode");
                $pesanKiriman =
                    "Berikut informasi Data Alumni :\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Cek Alumni':
                // Cek Alumni/Alumni/nis
                // Log::info("Request received: Number - $number, Nis - $nis dan Kode = $Kode");
                $pesanKiriman =
                    "Berikut informasi Data Alumni :\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
