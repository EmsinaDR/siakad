<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_KurikulumHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('Auto_Reply_KurikulumHelper')) {
    function Auto_Reply_KurikulumHelper($Kode, $NoRequest, $message)
    {
        switch ($Kode) {
            //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
            case 'Perangkat Test':
                // Perangkat Test / Kurikulum / Ruang#Siswa / Jumlah Ruang / Cetak
                $sessions = config('whatsappSession.IdWaUtama');
                if (!config('whatsappSession.WhatsappDev')) {
                    //$NoTujuan = $siswa->no_hp;
                    //$NoTujuan = getNoTujuanOrtu($siswa);
                    $NoTujuan = config('whatsappSession.wakaKurikulum');
                } else {
                    $sessions = config('whatsappSession.IdWaUtama');
                    $NoTujuan = config('whatsappSession.DevNomorTujuan');
                }
                
                $PesanKirim =
                    "isiPesan \n" .
                    "\n";

                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Perangkat Test', $PesanKirim));
                break;
            //case 'Siswa':
            //break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
