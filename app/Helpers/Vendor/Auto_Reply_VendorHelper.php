<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_VendorHelper
    |----------------------------------------------------------------------
    |
*/
if (!function_exists('cekVendor')) {
    function cekVendor($NoRequest, $sessions)
    {
        if ($NoRequest != config('whatsappSession.DevNomorTujuan')) {
            return \App\Models\Whatsapp\WhatsApp::sendMessage(
                $sessions,
                $NoRequest,
                'Maaf, akses ini hanya untuk vendor'
            );
        }

        return true; // artinya lolos vendor
    }
}
if (!function_exists('Auto_Reply_VendorHelper')) {
    function Auto_Reply_VendorHelper($Kode, $NoRequest, $message, $sessions)
    {
        cekVendor($NoRequest, $sessions);
        $Kontak = config('whatsappSession.DevNomorTujuan');
        switch ($Kode) {
            case 'Data Vendor':
                $pesan =
                    "Vendor : Ata Digital\n" .
                    "Kontak : {$Kontak}\n" .
                    "Alamat : Jln. Makensi Desa Banjarharjo Kecamatan Banjarharjo, Kabupaten Brebes Kode POS : 52265\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Fitur Aplikas':
                $pesan =
                    "- Absensi\n" .
                    "- PPDB\n" .
                    "- Perpustakaan\n";
                return $pesan;
                break;
            case 'Teruskan':
                // Teruskan/Vendor/Guru:Siswa:Wali/isipesan/
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
                $pesan =
                    "- Absensi\n" .
                    "- PPDB\n" .
                    "isiCode\n";
                return $pesan;
                break;
            // Management Server
            case 'Cek Service':
                $pesan = CekServices();
                \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Informasi Service',  $pesan));
                break;
            case 'Restart Service':
                $pesan = RestartServices();
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Restart PC':
                $pesan = RestartPC();
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Shutdown PC':
                $pesan = ShutdownPC();
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'BatPC':
                $result = run_bat("executor\contoh.bat");
                $pesan =
                    "*Path  :*\n{$result['path']}\n" .
                    "*File  :*\n{$result['success']}\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;

            default:
                return "Tidak ada kode pesan yang sesuai ";
        }
    }
}
