<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_PPDBHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('Auto_Reply_PPDBHelper')) {
    function Auto_Reply_PPDBHelper($Kode, $Siswa, $NoRequest, $message)
    {
        $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
        /*
           $xxxxxxx = $pesan[0];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[1];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[2];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[3];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[4];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[5];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[6];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[7];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[8];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[9];  -> xxxxxxxxxxxx
           $xxxxxxx = $pesan[10];  -> xxxxxxxxxxxx
        */
        if (!config('whatsappSession.WhatsappDev')) {
            //$sessions = getWaSession($siswa->tingkat_id); // by tingkat ada di dalamnya
            //$sessions = config('whatsappSession.IdWaUtama');
            //$NoTujuan = getNoTujuanOrtu($siswa)
            $NoTujuan = $NoRequest;
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        switch ($Kode) {
            //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
            // Kode / PPDB
            case 'Informasi Pendaftaran':
                $pesanKiriman =
                    "Berikut ini informasi PPDB yang diminta, silahkan diperhatikan jika ada yang di tanyakan bisa menghubungi kontak pantia \n" .
                    "Waktu Pendaftaran : Mulai Tanggal 14 Juni - 25 Juli 2026 \n" .
                    "*Persyaratan :* \n" .
                    "- Pas Foto 3 X 4 ( 2 Lembar )\n" .
                    "- Legalisir FC Ijazah \n" .
                    "- Legalisir FC SKHUN \n" .
                    "- Scan/Foto Kartu Keluarga format JPG \n" .
                    "- Foto Copy Raport \n" .
                    "- Foto Kartu keluarga \n" .
                    "- Foto KTP Ayah \n" .
                    "- Foto KTP Ibu \n" .
                    "*Formulir :* \n" .
                    "- Formulir Digital : \n" .
                    "*Kontak Panitia :* \n" .
                    "Dany Rosepta - *(6285329860005)* \n" .
                    "{$message}\n" .
                    " \n\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Informasi Pendaftaran PPDB', $pesanKiriman));
                break;
            case 'Pendaftaran':
                break;
            case 'Cek Pendaftaran':
                break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
        return "Helper Auto_Reply_PPDBHelper dijalankan dengan param: ";
    }
}
