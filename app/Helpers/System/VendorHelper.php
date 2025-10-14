<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper VendorHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('KirimVendor')) {
    function KirimVendor($pesanKiriman)
    {
        //Isi Fungsi
        $sessions = config('whatsappSession.IdWaUtama');
        $waData = [
            config('whatsappSession.NoKepala'),
            config('whatsappSession.DevNomorTujuan')
        ];
        foreach ($waData as $kirikke):
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $kirikke, format_pesan('Informasi Backup Database', $pesanKiriman));
        endforeach;
    }
}
