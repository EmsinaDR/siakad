<?php

use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_ControlHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('Auto_Reply_ControlHelper')) {
    function Auto_Reply_ControlHelper($Kode, $NoRequest, $message)
    {

        $data = explode('/', $message);
        $Guru = Detailguru::where('kode_guru', $data[2])->first();
        $sessions = config('whatsappSession.IdWaUtama');
        if (!validateWhatsappAccessGuruUmum($NoRequest, $Guru)) {
            return; // stop eksekusi
        }
        switch ($Kode) {
            //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
            case 'X PC':
                // Restart PC/Control/Kode Guru
                // $pesan = RestartPC();
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', 'xPC'));
                break;
            case 'Restart PC':
                // Restart PC/Control/Kode Guru
                $pesan = RestartPC();
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Shutdown PC':
                $pesan = ShutdownPC();
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Restart Service':
                $pesan = RestartServices();
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Cek Service':
                $pesan = CekServices();
                \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Informasi Service',  $pesan));
                break;
            //case 'Siswa':
            //break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
        // return "Helper Auto_Reply_ControlHelper dijalankan dengan param: ";
    }
}
