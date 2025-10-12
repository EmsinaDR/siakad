<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_VendorHelper
    |----------------------------------------------------------------------
    |
*/

use App\Models\Admin\Ekelas;
use App\Models\Whatsapp\WhatsApp;
use App\Models\AdminDev\DataVendor;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;

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
                // Teruskan/Vendor/Guru:Siswa:Wali:Wali Kelas/isipesan/
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
                if ($pesan[2] === 'Guru') {
                } elseif ($pesan[2] === 'Siswa') {
                } elseif ($pesan[2] === 'Wali') {
                } elseif ($pesan[2] === 'Wali Kelas') {
                    $WaliKelasId = Ekelas::pluck('detailguru_id');
                    $NoWaliKelas = Detailguru::whereIn('id', $WaliKelasId)->pluck('no_hp');
                    $pesan =
                        "Di informasikan kepada wali kelas :\n" .
                        "$pesan[3]\n\n" .
                        // "{json_encode($NoWaliKelas)}\n" .
                        "Ganti Tanda *#* dengan */*\n" .
                        "Semoga bermanfaat dan mempermudah proses kerja Bapak / Ibu.\n";
                    if (!config('whatsappSession.WhatsappDev')) {
                        foreach ($NoWaliKelas as $walkes):
                            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $walkes, format_pesan('Informasi Vendor', $pesan));
                        endforeach;
                    } else {
                        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Informasi Vendor', $pesan));
                    }
                }


                return false;

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
            case 'Siswa Baru':
                $keyMessage = 'Case / Vendor / Data'; // Case / Guru / Kode_guru
                $dataPesan = combine_format_pesan($keyMessage, $message);
                // Untuk pengecekan bisa gunakan : dump::pesan-wa-dump-pesan-whatsapp-laravel

                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, json_encode($dataPesan));

                /*
                   Untuk pengiriman tanpa media
                   $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $PesanKirim);

                   Untuk pengiriman Dengan media
                       $filename = 'namafile_disertai_ekstensi';
                       //CopyFileWa(filename, 'template'); // template : folder di public jika diperlukan
                       $FileKiriman  = base_path('whatsapp/uploads/' . $filename);
                       $caption =
                       "$isi_pesan\n".
                       "*Terima Kasih.*\n";
                       sleep(10);
                       $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_media("Generator {$Kode}", $caption), $FileKiriman);
                       sleep(10);
                       hapusFileWhatsApp($FileKiriman, $filename);
                   */
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
                $result = UpdateWhatsapp();
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
                $result = UpdateSiakad();
                $pesan =
                    "*Path  :*\n{$result['path']}\n" .
                    "*File  :*\n{$result['success']}\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Aktivasi Modul':
                $result = run_bat("executor\siakad\update.bat");
                $pesan =
                    "*Path  :*\n{$result['path']}\n" .
                    "*File  :*\n{$result['success']}\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Vendor', $pesan));
                break;
            case 'Generate Karpel':
                // Case / Vendor / nis / dokumen
                $pesan = explode('/', $message);
                $dokumen = $pesan[3];
                // $DataNis
                if ($dokumen === 'karpel') {
                    $kodeKarpel = 11;
                    $folder = 'img/template/karpel';
                    $arrayNis = explode(':', $pesan[2]);
                    $idsiswas = Detailsiswa::whereIn('nis', $arrayNis)->pluck('id');
                    foreach ($idsiswas as $IdSiswa) {
                        $KarpelDepan = generatekarpel_depan($IdSiswa, $kodeKarpel, $folder);
                        $Carifilename = $KarpelDepan['nis'] . '.png';
                        $copyFile = CopyDataSiswa($Carifilename, 'img/karpel/');
                        $pesan =
                            "Karpel Bagian Depan\n" .
                            "\n";
                        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Generate Karpel Depan', $pesan));
                        $KarpelBelakang = generatekarpel_belakang($IdSiswa, $kodeKarpel, $folder);
                        $Carifilename = 'belakang_' . $KarpelBelakang['nis'] . '.png';
                        $copyFile = CopyDataSiswa($Carifilename, 'img/karpel/');
                        $pesan =
                            "Karpel Bagian Belakang\n" .
                            "\n";
                        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Generate Karpel Belakang', $pesan));
                    }
                } elseif ($dokumen === 'nisn') {
                } else {
                }
                break;
            case 'Info Update Data Bantuan':
                //Info Update Data Bantuan / Vendor / nis
                $pesan = explode('/', $message);
                $siswa = Detailsiswa::where('nis', $pesan[2])->first();
                $isiPesan =
                    "Update Siswa/Vendor/{$pesan[2]}/\n" .
                    "kartu_bantuan_1:{$siswa->kartu_bantuan_1}\n" .
                    "kartu_bantuan_2:{$siswa->kartu_bantuan_2}\n" .
                    "kartu_bantuan_3:{$siswa->kartu_bantuan_3}\n" .
                    "kartu_bantuan_4:{$siswa->kartu_bantuan_4}\n" .
                    "kartu_bantuan_5:{$siswa->kartu_bantuan_5}\n";

                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Info Update Data Siswa':
                //Info Update Data Siswa / Vendor / nis
                $pesan = explode('/', $message);
                $siswa = Detailsiswa::where('nis', $pesan[2])->first();
                $isiPesan =
                    "Update Siswa/Vendor/$pesan[2]/\n" .
                    "nama_siswa:{$siswa->nama_siswa}\n" .
                    "nama_panggilan:{$siswa->nama_panggilan}\n" .
                    "nik:{$siswa->nik}\n" .
                    "nokk:{$siswa->nokk}\n" .
                    "hobi:{$siswa->hobi}\n" .
                    "cita_cita:{$siswa->cita_cita}\n" .
                    "waktu_tempuh:{$siswa->waktu_tempuh}\n" .
                    "status_tempat_tinggal:{$siswa->waktu_tempuh}\n" .
                    "transportasi_berangkat:{$siswa->transportasi_berangkat}\n" .
                    "jenis_kelamin:{$siswa->jenis_kelamin}\n" .
                    "tempat_lahir:{$siswa->tempat_lahir}\n" .
                    "tanggal_lahir:{$siswa->tanggal_lahir}\n" .
                    "nohp_siswa:{$siswa->nohp_siswa}\n" .
                    "agama:{$siswa->agama}\n" .
                    "kewarganegaraan:{$siswa->kewarganegaraan}\n" .
                    "anak_ke:{$siswa->anak_ke}\n" .
                    "jml_saudara:{$siswa->jml_saudara}\n" .
                    "jumlah_saudara_tiri:{$siswa->jumlah_saudara_tiri}\n" .
                    "jumlah_saudara_angkat:{$siswa->jumlah_saudara_angkat}\n" .
                    "status_anak:{$siswa->status_anak}\n" .
                    "status_yatim_piatu:{$siswa->status_yatim_piatu}\n" .
                    "bahasa:{$siswa->bahasa}\n" .
                    "alamat_siswa:{$siswa->alamat_siswa}\n" .
                    "jalan:{$siswa->jalan}\n" .
                    "rt:{$siswa->rt}\n" .
                    "rw:{$siswa->rw}\n" .
                    "desa:{$siswa->desa}\n" .
                    "kecamatan:{$siswa->kecamatan}\n" .
                    "kabupaten:{$siswa->kabupaten}\n" .
                    "provinsi:{$siswa->provinsi}\n" .
                    "kode_pos:{$siswa->kode_pos}\n" .
                    "tinggal_bersama:{$siswa->tinggal_bersama}\n" .
                    "jarak_sekolah:{$siswa->jarak_sekolah}\n" .
                    "golongan_darah:{$siswa->golongan_darah}\n" .
                    "riwayat_penyakit:{$siswa->riwayat_penyakit}\n" .
                    "kelainan_jasmani:{$siswa->kelainan_jasmani}\n" .
                    "tinggi_badan:{$siswa->tinggi_badan}\n" .
                    "berat_badan:{$siswa->berat_badan}\n" .
                    "namasek_asal:{$siswa->namasek_asal}\n" .
                    "alamatsek_asal:{$siswa->alamatsek_asal}\n" .
                    "tanggal_ijazah_sd:{$siswa->tanggal_ijazah_sd}\n" .
                    "nomor_ijazah_sd:{$siswa->nomor_ijazah_sd}\n" .
                    "lama_belajar:{$siswa->lama_belajar}\n" .
                    "asal_pindahan:{$siswa->asal_pindahan}\n" .
                    "alasan_pindahan:{$siswa->alasan_pindahan}\n" .
                    "tanggal_penerimaan:{$siswa->tanggal_penerimaan}\n" .
                    "jabatan_kelas:{$siswa->jabatan_kelas}\n" .
                    "piket_kelas:{$siswa->piket_kelas}\n" .
                    "petugas_upacara:{$siswa->petugas_upacara}\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Info Update Data Ayah':
                //Info Update Data Ayah / Vendor / nis
                $pesan = explode('/', $message);
                $siswa = Detailsiswa::where('nis', $pesan[2])->first();
                $isiPesan =
                    "Update Siswa/Vendor/$pesan[2]/\n" .
                    "ayah_nama:{$siswa->ayah_nama}\n" .
                    "ayah_nik:{$siswa->ayah_nik}\n" .
                    "ayah_pekerjaan:{$siswa->ayah_pekerjaan}\n" .
                    "ayah_keadaan:{$siswa->ayah_keadaan}\n" .
                    "ayah_agama:{$siswa->ayah_agama}\n" .
                    "ayah_pendidikan:{$siswa->ayah_pendidikan}\n" .
                    "ayah_penghasilan:{$siswa->ayah_penghasilan}\n" .
                    "ayah_nohp:{$siswa->ayah_nohp}\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Ayah', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Info Update Data Ibu':
                //Info Update Data Ibu / Vendor / nis
                $pesan = explode('/', $message);
                $siswa = Detailsiswa::where('nis', $pesan[2])->first();
                $isiPesan =
                    "Update Siswa/Vendor/$pesan[2]/\n" .
                    "ibu_nama:{$siswa->ibu_nama}\n" .
                    "ibu_nik:{$siswa->ibu_nik}\n" .
                    "ibu_pekerjaan:{$siswa->ibu_pekerjaan}\n" .
                    "ibu_keadaan:{$siswa->ibu_keadaan}\n" .
                    "ibu_agama:{$siswa->ibu_agama}\n" .
                    "ibu_pendidikan:{$siswa->ibu_pendidikan}\n" .
                    "ibu_penghasilan:{$siswa->ibu_penghasilan}\n" .
                    "ibu_nohp:{$siswa->ibu_nohp}\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Ibu', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Info Update Data Wali':
                //Info Update Data Ibu / Vendor / nis
                $pesan = explode('/', $message);
                $siswa = Detailsiswa::where('nis', $pesan[2])->first();
                $isiPesan =
                    "Update Siswa/Vendor/$pesan[2]/\n" .
                    "wali_nama:{$siswa->wali_nama}\n" .
                    "wali_nik:{$siswa->wali_nik}\n" .
                    "wali_pekerjaan:{$siswa->wali_pekerjaan}\n" .
                    "wali_keadaan:{$siswa->wali_keadaan}\n" .
                    "wali_agama:{$siswa->wali_agama}\n" .
                    "wali_pendidikan:{$siswa->wali_pendidikan}\n" .
                    "wali_penghasilan:{$siswa->wali_penghasilan}\n" .
                    "wali_nohp:{$siswa->wali_nohp}\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Wali', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;


            case 'Update Siswa':
                //Tester / Guru / Kode Guru / xxxxxxxxxx
                /* $message = "
                Case / bagian / 250001/
                Update NB/Operator/250001/
                kartu_bantuan_1:1000
                kartu_bantuan_2:
                kartu_bantuan_3:500
                kartu_bantuan_4:
                kartu_bantuan_5:200

                */
                $message = preg_replace("/\r\n|\n|\r/", "/", $message);
                // Split pesan dan trim
                $parts = array_map('trim', explode('/', $message));
                // Ambil model siswa
                $siswa = Detailsiswa::where('nis', $parts[2])->first();
                // Assign key:value ke model
                ArrayUpdateDataWa($parts, $siswa, 3); // skip 4 bagian pertama jika perlu
                // Simpan perubahan
                $siswa->save();

                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, json_encode($kartuParts));
                // Bagian Pesan Update
                $parts = array_slice($parts, 3);
                $dataUpdate = '';
                foreach ($parts as $key => $value):
                    $value_update = str_replace(':', ' : ', $value);
                    $dataUpdate .= "{$value_update}\n";
                endforeach;
                $isiPesan =
                    "Data telah di update harap periksa kembali\n" .
                    "{$dataUpdate}\n" .
                    // "{$message}\n" .
                    // "json_encode($kartuData)-\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                return $result;
                break;
            default:
                return "Tidak ada kode pesan yang sesuai ";
        }
    }
}
