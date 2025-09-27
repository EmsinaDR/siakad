<?php

use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;

/*
    |----------------------------------------------------------------------
    | 📌 Helper ValidationAksesHelper
    |----------------------------------------------------------------------
    |
*/

// Bebas akses data guru ke pribadi
if (!function_exists('validateWhatsappAccess')) {
    function validateWhatsappAccessGuruPrivate($NoRequest, $Guru)
    {
        $sessions = config('whatsappSession.IdWaUtama');
        $DevNomor = config('whatsappSession.DevNomorTujuan');
        $SekolahNoTujuan = config('whatsappSession.SekolahNoTujuan');

        // Loloskan nomor Dev
        if ($NoRequest !== $DevNomor) {
            if (!$Guru || ($NoRequest !== $Guru->no_hp && $NoRequest !== config('whatsappSession.NoKepala'))) {
                // Kirim pesan kalau tidak diijinkan
                WhatsApp::sendMessage($sessions, $NoRequest, format_pesan(
                    "❌ Informasi",
                    "Maaf anda tidak berhak mengakses data ini!!!\n*NO HP tidak terdaftar*"
                ));

                $PesanKirim = "Di informasikan bahwa ada akses tidak sah dari :\n" .
                    "No HP : {$NoRequest}\n" .
                    "Berusaha mencoba akses data Guru :\n" .
                    "Nama : " . ($Guru->nama_guru ?? '-') . "\n";

                WhatsApp::sendMessage($sessions, $SekolahNoTujuan, format_pesan('⚠️ Informasi Warning ⚠️', $PesanKirim));

                return false;
            }
        }

        return true;
    }
}
// Bebas akses data guru ke guru
if (!function_exists('validateWhatsappAccessGuruUmum')) {
    function validateWhatsappAccessGuruUmum($NoRequest, $Guru)
    {
        $sessions = config('whatsappSession.IdWaUtama');
        $DevNomor = config('whatsappSession.DevNomorTujuan');
        $SekolahNoTujuan = config('whatsappSession.SekolahNoTujuan');
        $NoHPAllGuru = Detailguru::pluck('no_hp')->toArray(); // pastikan array
        // Loloskan nomor Dev
        if ($NoRequest !== $DevNomor) {
            if (!$Guru || (!in_array($NoRequest, $NoHPAllGuru) && $NoRequest !== config('whatsappSession.NoKepala'))) {
                // Kirim pesan kalau tidak diijinkan
                WhatsApp::sendMessage($sessions, $NoRequest, format_pesan(
                    "❌ Informasi",
                    "Maaf anda tidak berhak mengakses data ini!!!\n*NO HP tidak terdaftar*"
                ));

                $PesanKirim = "Di informasikan bahwa ada akses tidak sah dari :\n" .
                    "No HP : {$NoRequest}\n" .
                    "Berusaha mencoba akses data Guru :\n" .
                    "Nama : " . ($Guru->nama_guru ?? '-') . "\n";

                WhatsApp::sendMessage($sessions, $SekolahNoTujuan, format_pesan('⚠️ Informasi Warning ⚠️', $PesanKirim));

                return false;
            }
        }

        return true;
    }
}
if (!function_exists('ValidateGuruAksesSiswa')) {
    function ValidateGuruAksesSiswa($NoRequest)
    {
        //Isi Fungsi
        $NoHPAllGuru = Detailguru::pluck('no_hp')->toArray();
        if (!in_array($NoRequest, $NoHPAllGuru)) {
            return false;
        }
        return true;
    }
}
// Validasi Ortu dan Guru
if (!function_exists('valdiateOrtu')) {
    function valdiateOrtu($NoRequest, $Nis)
    {
        //Isi Fungsi
        $DataSiswa = Detailsiswa::with('kelas')->where('nis', $Nis)->first();
        $ceksiswa = $DataSiswa->where('ayah_nohp', $NoRequest)->orWhere('ibu_nohp', $NoRequest)->first();
        $kelas = $DataSiswa->kelas->kelas;
        $nama = $DataSiswa->nama_siswa;
        if (!config('whatsappSession.WhatsappDev')) {
            $sessions = getWaSession(); // by tingkat ada di dalamnya
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
            $SekolahNoTujuan = config('whatsappSession.SekolahNoTujuan');
        }
        if (!$ceksiswa) {
            // Ijin akses dev
            if ($NoRequest === config('whatsappSession.DevNomorTujuan') || ValidateGuruAksesSiswa($NoRequest)) {
                return true;
            }
            // info ke yang request
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan("❌ Informasi", "Maaf anda tidak berhak mengakses data ini!!!\n*NO HP tidak terdaftar*"));
            // Warning ke pihak sekolah
            $PesanKirim =
                "Di informasikan bahwa ada akses tidak sah dari :\n" .
                "No HP : {$NoRequest}\n" .
                "Berusaha mencoba akses data siswa :\n" .
                "Nama : {$nama}\n" .
                "Kelas : {$kelas}\n" .
                "\n";

            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $SekolahNoTujuan, format_pesan('⚠️ Informasi Warning ⚠️', $PesanKirim));
            return false;
        }
        return true;
    }
}
// Validasi BendaharaBos
function validate_BendaharaBos($NoRequest)
{
    $allowed = [
        config('whatsappSession.NoBendaharaBos'),
        config('whatsappSession.NoKepala'),
        config('whatsappSession.DevNomorTujuan')
    ];

    if (in_array($NoRequest, $allowed)) {
        return true;
    }
    return false;
}
// Validasi BendaharaKomite
function validate_BendaharaKomite($NoRequest)
{
    $allowed = [
        config('whatsappSession.NoBendaharaKomite'),
        config('whatsappSession.NoKepala')
    ];
    if (in_array($NoRequest, $allowed)) {
        return true;
    }
    return false;
}
// Validasi Kepala
function validate_Kepala($NoRequest)
{
    $allowed = [
        config('whatsappSession.NoKepala'),
        config('whatsappSession.DevNomorTujuan')
    ];
    if (in_array($NoRequest, $allowed)) {
        return true;
    }
    return false;
}
