<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_Database
    |----------------------------------------------------------------------
    |
*/

use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;

if (!function_exists('Auto_Reply_Database')) {
    function Auto_Reply_Database($Kode, $NoRequest, $message)
    {
        // Kode/ Update / Guru # Siswa / Kode Guru # Nis / field / isifield
        $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
        if ($pesan[2] === 'Siswa') {
            $siswa = Detailsiswa::where('nis', $pesan[3])->firest();
        } else {
            $Guru = Detailguru::where('kode_guru', $pesan[3])->firest();
        }

        if (!config('whatsappSession.WhatsappDev')) {
            if (!config('whatsappSession.SingleSession')) {
                $sessions = $pesan[2] === 'Siswa' ? getWaSession($siswa->tingkat_id) : config('whatsappSession.IdWaUtama'); // jika single whatsapp kosongkan tingkat
            } else {
                $sessions = $pesan[2] === 'Siswa' ? getWaSession() : config('whatsappSession.IdWaUtama');
            }
            $NoTujuan = $pesan[2] === 'Siswa' ? getNoTujuanOrtu($siswa) : $Guru->no_hp;
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        switch ($Kode) {
            //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp

            case 'Siswa':
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
                $PesanKirim =
                    "xxxxxxxxxx\n" .
                    "xxxxxxxxxx\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $PesanKirim);
                break;
            case 'Guru':
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

                break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
        return "Helper Auto_Reply_Database dijalankan dengan param: ";
    }
}
