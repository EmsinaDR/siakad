<?php

use App\Models\User\Siswa\Detailsiswa;

/*
    |----------------------------------------------------------------------
    | 📌 Helper Surat
    |----------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxx
    | Tujuan :
    | - xxxxx
    | Penggunaan :
    | - xxxxx
    |
*/

// Proses Coding
if (!function_exists('Whatsaap_surat_siswa')) {
    function Whatsaap_surat_siswa($data)
    {
        //Isi Fungsi
        $siswa = Detailsiswa::where('nis', $data['nis'])->first();
        if (!config('whatsappSession.WhatsappDev')) {
            if (!config('whatsappSession.SingleSession')) {
                $sessions = getWaSession($siswa->tingkat_id); // jika single whatsapp kosongkan tingkat
            } else {
                $sessions = getWaSession();
            }
            $NoTujuan = getNoTujuanOrtu($siswa);
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        $tanggal_kunjungan = \Carbon\Carbon::now()->addDays((int)$data['tanggal_kunjungan'])->translatedformat('l, d F Y');

        if (ucfirst($data['kirim_wa']) === 'Ya') {
            $pesanKirim =
                "Di informasikan kepada Bapak / Ibu, bahwa pada hari {$tanggal_kunjungan}, perwakilan sekolah akan datang berkunjung kerumah guna mendapatkan informasi / membahas terkait ananda *{$siswa->nama_siswa}*, berikut informasi yang dapat kami sampaikan :\n\n" .
                "Hari dan Tanggal Kunjungan :\n{$tanggal_kunjungan}.\n" .
                "Jam :\n{$data['jam_kunjungan']}\n\n" .
                "Dimohon Bapak / Ibu berkenan menemui sebagai wali dari ananda *{$siswa->nama_siswa}*.\n" .
                "Demikian informasi yang dapat kami sampaikan, atas segala perhatian dan kerjasamanya kami sampaikan banyak terima kasih.\n";
            // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan("Informasi Home Visit", 'is ortu'));
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan("Informasi Home Visit", $pesanKirim));
        }
    }
}
