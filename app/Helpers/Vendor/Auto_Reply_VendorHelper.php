<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_VendorHelper
    |----------------------------------------------------------------------
    |
*/

use App\Models\AdminDev\DataVendor;

if (!function_exists('cekVendor')) {
    function cekVendor($NoRequest, $sessions)
    {
        if ($NoRequest != config('whatsappSession.DevNomorTujuan')) {
            return \App\Models\Whatsapp\WhatsApp::sendMessage(
                $sessions,
                $NoRequest,
                "Maaf, akses ini hanya untuk vendor"
            );
        }

        return true; // artinya lolos vendor
    }
}
if (!function_exists('Auto_Reply_VendorHelper')) {
    function Auto_Reply_VendorHelper($Kode, $NoRequest, $message, $sessions)
    {
        cekVendor($NoRequest, $sessions);
        $Vendor = DataVendor::first();
        $Kontak = config('whatsappSession.DevNomorTujuan');
        // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, "{$Kode}{$NoRequest}{$message}{$sessions}");
        switch ($Kode) {
            case 'Data Vendor':
                $pesan =
                    "Vendor :\n Ata Digital\n" .
                    "Kontak :\n {$Kontak}\n" .
                    "Twiter :\n {$Vendor->twiter}\n" .
                    // "Youtube :\n {$Vendor->youtube}\n" .
                    "Instagram :\n {$Vendor->instagram}\n" .
                    "Whatsapp Comunity :\n {$Vendor->whatsap_komunitas}\n" .
                    "Facebook FP :\n {$Vendor->facebook_fanspage}\n" .
                    "Facebook User :\n {$Vendor->facebook_user}\n" .
                    "Youtube :\n {$Vendor->github}\n" .
                    "Alamat :\n Jln. Makensi Desa Banjarharjo Kecamatan Banjarharjo, Kabupaten Brebes Kode POS : 52265\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Full Vendor':
                $pesan =
                    "Vendor :\n Ata Digital\n" .
                    "Gihub :\n {$Vendor->github}\n" .
                    "Facebook FP :\n {$Vendor->facebook_fanspage}\n" .
                    "Facebook User :\n {$Vendor->facebook_user}\n" .
                    "Alamat : Jln. Makensi Desa Banjarharjo Kecamatan Banjarharjo, Kabupaten Brebes Kode POS : 52265\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Fitur Aplikasi':
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
            // Data Siswa Uji Coba
            case 'Field Data Siswa':
                $pesan =
                    "Data Siswa\nuser_id:\nppdb_id:\nstatus_siswa:\nnis:\nnisn:\nnama_siswa:\nnama_panggilan:\nnik:\nnokk:\nhobi:\ncita_cita:\njenis_kelamin:\ntempat_lahir:\ntanggal_lahir:\nnohp_siswa:\nagama:\nkewarganegaraan:\nanak_ke:\njml_saudara:\njumlah_saudara_tiri:\njumlah_saudara_angkat:\nstatus_anak:\nstatus_yatim_piatu:\nbahasa:\nalamat_siswa:\njalan:\nrt:\nrw:\ndesa:\nkecamatan:\nkabupaten:\nprovinsi:\nkode_pos:\ntinggal_bersama:\njarak_sekolah:\ngolongan_darah:\nriwayat_penyakit:\nkelainan_jasmani:\ntinggi_badan:\nberat_badan:\nnamasek_asal:\nalamatsek_asal:\ntanggal_ijazah_sd:\nnomor_ijazah_sd:\nlama_belajar:\nasal_pindahan:\nalasan_pindahan:\nkelas_penerimaan:\nkelompok_penerimaan:\njurusan_penerimaan:\ntanggal_penerimaan:\ntahun_masuk:\ntahun_lulus:\ntingkat_id:\nkelas_id:\njabatan_kelas:\npiket_kelas:\npetugas_upacara:\nayah_nama:\nayah_keadaan:\nayah_agama:\nayah_kewarganegaraan:\nayah_pendidikan:\nayah_pekerjaan:\nayah_penghasilan:\nayah_alamat:\nayah_rt:\nayah_rw:\nayah_desa:\nayah_kecamatan:\nayah_kabupaten:\nayah_provinsi:\nayah_kodepos:\nayah_nohp:\nibu_nama:\nibu_keadaan:\nibu_agama:\nibu_kewarganegaraan:\nibu_pendidikan:\nibu_pekerjaan:\nibu_penghasilan:\nibu_alamat:\nibu_rt:\nibu_rw:\nibu_desa:\nibu_kecamatan:\nibu_kabupaten:\nibu_provinsi:\nibu_kodepos:\nibu_nohp:\nwali_nama:\nwali_keadaan:\nwali_agama:\nwali_kewarganegaraan:\nwali_pendidikan:\nwali_pekerjaan:\nwali_penghasilan:\nwali_alamat:\nwali_rt:\nwali_rw:\nwali_desa:\nwali_kecamatan:\nwali_kabupaten:\nwali_provinsi:\nwali_kodepos:\nwali_nohp:\n";
                \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Insert Data Siswa',  $pesan));
                break;
            case 'Insert Siswa':
                $baris = preg_replace("/\r\n|\n|\r/", "/", $message);
                $cobaarray = json_encode(string_to_array($baris));
                $pesan =
                    "Data Siswa\n" .
                    "- PPDB\n\n" .
                    "- {$cobaarray}\n\n" .
                    "- {$message}\n" .
                    "- {$baris}\n";
                \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Insert Data Siswa',  $pesan));
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
            case 'Update Whatsapp':
                $result = run_bat("executor\whatsapp\update.bat");
                $pesan =
                    "*Path  :*\n{$result['path']}\n" .
                    "*File  :*\n{$result['success']}\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Update Modul':
                $result = run_bat("executor\siakad\contoh.bat");
                $pesan =
                    "*Path  :*\n{$result['path']}\n" .
                    "*File  :*\n{$result['success']}\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Update Siakad':
                $result = run_bat("executor\siakad\update.bat");
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
