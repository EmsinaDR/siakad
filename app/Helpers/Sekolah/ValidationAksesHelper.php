<?php

use App\Models\Whatsapp\WhatsApp;

/*
    |----------------------------------------------------------------------
    | 📌 Helper ValidationAksesHelper
    |----------------------------------------------------------------------
    |
*/
if (!function_exists('validateWhatsappAccess')) {
    function validateWhatsappAccess($NoRequest, $Guru)
    {
        $sessions = config('whatsappSession.IdWaUtama');
        $DevNomor = config('whatsappSession.DevNomorTujuan');
        $SekolahNoTujuan = config('whatsappSession.SekolahNoTujuan');

        // Loloskan nomor Dev
        if ($NoRequest !== $DevNomor) {
            if (!$Guru || $NoRequest !== $Guru->no_hp) {
                // Kirim pesan kalau tidak diijinkan
                WhatsApp::sendMessage($sessions, $NoRequest, format_pesan(
                    "❌ Informasi",
                    "Maaf anda tidak berhak mengakses data ini!!!\n*NO HP tidak terdaftar*"
                ));

                $PesanKirim = "Di informasikan bahwa ada akses tidak sah dari :\n" .
                    "No HP : {$NoRequest}\n" .
                    "Berusaha mencoba akses data siswa :\n" .
                    "Nama : " . ($Guru->nama_guru ?? '-') . "\n";

                WhatsApp::sendMessage($sessions, $SekolahNoTujuan, format_pesan('⚠️ Informasi Warning ⚠️', $PesanKirim));

                return false;
            }
        }

        return true;
    }
}
