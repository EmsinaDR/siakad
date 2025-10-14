<?php

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\DB;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 Auto_Reply_OperatorHelper :
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - xxxxxxxxxxx
        | - xxxxxxxxxxx
        |
        | Tujuan :
        | - xxxxxxxxxxx
        |
        | Penggunaan :
        | - xxxxxxxxxxx
        |
    */

// Proses Coding
if (!function_exists('Auto_Reply_OperatorHelper')) {
    function Auto_Reply_OperatorHelper($Kode, $NoRequest, $message)
    {
        // TODO: Implement your helper logic here
        // Khusus Operator
        $baris = preg_replace("/\r\n|\n|\r/", "/", $message);
        if (!config('whatsappSession.WhatsappDev')) {
            //$sessions = getWaSession($siswa->tingkat_id); // by tingkat ada di dalamnya
            //$sessions = config('whatsappSession.IdWaUtama');
            //$NoTujuan = getNoTujuanOrtu($siswa)
            // $NoTujuan = $NoRequest;
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
            $NoRequest = config('whatsappSession.DevNomorTujuan');
        }
        $sessions = config('whatsappSession.IdWaUtama');
        switch (ucfirst($Kode)) {
            case 'Tester':
                //Tester / Guru / Kode Guru / xxxxxxxxxx
                $isiPesan =
                    "isikiriman\n" .
                    "{$baris}\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Info Nomor Bantuan':
                //Tester / Guru / Kode Guru / xxxxxxxxxx
                $isiPesan =
                    "Berikut data No Bantuan yang bisa di isi :\n" .
                    "Bantuan 1 : PIP\n" .
                    "Bantuan 2 : KIP\n" .
                    "Bantuan 3 : Beasiswa Prestasi / Akademik\n" .
                    "Bantuan 4 : Program Khusus / Yayasan / CSR\n" .
                    "Bantuan 5 : -\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Cek Penerima Bantuan':
                //Cek Penerima Bantuan / Operator / Siswa / bantuan_1 #bantuan_2 #bantuan_3 #bantuan_4 #bantuan_5
                $isiPesan =
                    "Berikut data No Bantuan yang bisa di isi :\n" .
                    "Nama Siswa : PIP\n" .
                    "Bantuan 5 : -\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Field Nomor Bantuan':
                //Case / Operator / nis
                //_____________________________________________________________________________________
                //Dump Pesan Wa
                $message = $baris;
                $keyMessage = 'Case / bagian / nis / no_think / kartu_bantuan_1 / kartu_bantuan_2 / kartu_bantuan_3 / kartu_bantuan_4 / kartu_bantuan_5';
                $dataPesan = combine_format_pesan($keyMessage, $message);
                // $pesan = [];
                // foreach ($dataPesan as $key => $value) {
                //     $pesan[$key] => $value;
                // }

                // foreach ($dataPesan as $key => $value) {
                //     $data[$key] = $value;
                // }

                // $datasiswa = Detailsiswa::where('nis', $data['nis'])->first()->toArray();
                $siswa = Detailsiswa::where('nis', $dataPesan['nis'])->first();
                // $siswa['kartu_bantuan_1'] = $dataPesan['kartu_bantuan_1'];
                $siswa->kartu_bantuan_1 = empty($dataPesan['kartu_bantuan_1']) ? null : $dataPesan['kartu_bantuan_1'];
                $siswa->save(); // simpan perubahan

                $data = array_merge($dataPesan);
                $pesan =
                    // "{json_encode($siswa}\n";
                    // "{json_encode($siswaArray)}\n";
                    // "{json_encode($dataPesan)}\n";
                    "{ddddddddd}\n" .
                    "{$dataPesan['nis']}\n" .
                    "xxxx\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesan . "\n" . json_encode($siswa)  . "\n" .  json_encode($data));
                // return false;
                //_____________________________________________________________________________________
                $isiPesan =
                    "kartu_bantuan_1 : \n" .
                    "kartu_bantuan_2 : \n" .
                    "kartu_bantuan_3 : \n" .
                    "kartu_bantuan_4 : \n" .
                    "kartu_bantuan_5 : \n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $isiPesan);
                break;
            case 'Update Nomor Bantuan':
                //Tester / Guru / Kode Guru / xxxxxxxxxx
                $isiPesan =
                    "Berikut data No Bantuan yang bisa di isi :\n" .
                    "kartu_bantuan_1 : PIP\n" .
                    "kartu_bantuan_2 : KIP\n" .
                    "kartu_bantuan_3 : Beasiswa Prestasi / Akademik\n" .
                    "kartu_bantuan_4 : Program Khusus / Yayasan / CSR\n" .
                    "kartu_bantuan_5 : -\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Update NB':
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


                $isiPesan =
                    "Berikut data No Bantuan yang bisa di isi :\n" .
                    "kartu_bantuan_1 : PIP\n" .
                    "kartu_bantuan_2 : KIP\n" .
                    "kartu_bantuan_3 : Beasiswa Prestasi / Akademik\n" .
                    "kartu_bantuan_4 : Program Khusus / Yayasan / CSR\n" .
                    "kartu_bantuan_5 :zzzzzzzzzzzz\n" .
                    "-\n" .
                    // "{$message}\n" .
                    // "json_encode($kartuData)-\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                return $result;
                break;
            case 'Ubah Status Siswa':
                $keyMessage = 'Case / Operator / nis / Status'; // Status aktif#drop out#meninggal#lulus#pindah#mengundurkan diri#tidak dikenal
                // $dataPesan = combine_format_pesan($keyMessage, $message);
                // Untuk pengecekan bisa gunakan : dump::pesan-wa-dump-pesan-whatsapp-laravel

                $pesan = explode('/', $message);
                $arrayNis = explode(':', $pesan[2]);
                if ($pesan[3] === 'aktif') {
                    Detailsiswa::whereIn('nis', $arrayNis)
                        ->update([
                            'status_siswa' => $pesan[3],
                        ]);
                } else {
                    Detailsiswa::whereIn('nis', $arrayNis)
                        ->update([
                            'status_siswa' => $pesan[3],
                            'kelas_id' => null,
                        ]);
                }

                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $message);

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

            // Analisa

            case 'Sekolah Asal':
                // Case / Operator / tingkat
                // Sekolah Asal / Operator / tingkat
                $pesan = explode('/', $message);
                if (isset($pesan[2])) {
                    $SekolahAsal = Detailsiswa::select('namasek_asal', DB::raw('count(*) as total'))
                        ->where('status_siswa', 'aktif')
                        ->groupBy('namasek_asal')
                        ->where('tingkat_id', $pesan[2])
                        ->get();
                } else {
                    $SekolahAsal = Detailsiswa::select('namasek_asal', DB::raw('count(*) as total'))
                        ->where('status_siswa', 'aktif')
                        ->groupBy('namasek_asal')
                        ->get();
                }
                $dataSekolahAsal =
                    "Berikut data sekolah asal siswa yang tersedia :\n";
                foreach ($SekolahAsal as $index => $item) {
                    $sekolah_asal = $item->namasek_asal ?? '*Tidak Diketahui*';
                    $dataSekolahAsal .= $index + 1 . ". {$sekolah_asal} : {$item->total}\n";
                }
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Sekolah Asal Siswa', $dataSekolahAsal));
                break;

            case 'Umur Siswa':
                // Case / Operator / VII A
                // Umur Siswa / Operator / VII A
                // Hitung umur langsung dari tanggal_lahir
                $pesan = explode('/', $message);
                if (isset($pesan[2])) {
                    $kelas = Ekelas::where('kelas', $pesan[2])->first();
                    $umurSiswa = Detailsiswa::where(
                        'kelas_id',
                        $kelas->id
                    )->select(
                        DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) as umur'),
                        DB::raw('count(*) as total')
                    )
                        ->where('status_siswa', 'aktif')
                        ->groupBy('umur')
                        ->orderBy('umur')
                        ->get();
                } else {
                    $umurSiswa = Detailsiswa::select(
                        DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) as umur'),
                        DB::raw('count(*) as total')
                    )
                        ->where('status_siswa', 'aktif')
                        ->groupBy('umur')
                        ->orderBy('umur')
                        ->get();
                }

                $pesan = "Daftar Usia Siswa:\n";
                foreach ($umurSiswa as $index => $item) {
                    $pesan .= ($index + 1) . ". {$item->umur} tahun : {$item->total} siswa\n";
                }
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Sekolah Asal Siswa', $pesan));


                break;
            // Export Data
            case 'Field Data Siswa':
                // Field Data Siswa / Operator
                $pesan =
                    "Data Siswa\nuser_id:\nppdb_id:\nstatus_siswa:\nnis:\nnisn:\nnama_siswa:\nnama_panggilan:\nnik:\nnokk:\nhobi:\ncita_cita:\njenis_kelamin:\ntempat_lahir:\ntanggal_lahir:\nnohp_siswa:\nagama:\nkewarganegaraan:\nanak_ke:\njml_saudara:\njumlah_saudara_tiri:\njumlah_saudara_angkat:\nstatus_anak:\nstatus_yatim_piatu:\nbahasa:\nalamat_siswa:\njalan:\nrt:\nrw:\ndesa:\nkecamatan:\nkabupaten:\nprovinsi:\nkode_pos:\ntinggal_bersama:\njarak_sekolah:\ngolongan_darah:\nriwayat_penyakit:\nkelainan_jasmani:\ntinggi_badan:\nberat_badan:\nnamasek_asal:\nalamatsek_asal:\ntanggal_ijazah_sd:\nnomor_ijazah_sd:\nlama_belajar:\nasal_pindahan:\nalasan_pindahan:\nkelas_penerimaan:\nkelompok_penerimaan:\njurusan_penerimaan:\ntanggal_penerimaan:\ntahun_masuk:\ntahun_lulus:\ntingkat_id:\nkelas_id:\njabatan_kelas:\npiket_kelas:\npetugas_upacara:\nayah_nama:\nayah_keadaan:\nayah_agama:\nayah_kewarganegaraan:\nayah_pendidikan:\nayah_pekerjaan:\nayah_penghasilan:\nayah_alamat:\nayah_rt:\nayah_rw:\nayah_desa:\nayah_kecamatan:\nayah_kabupaten:\nayah_provinsi:\nayah_kodepos:\nayah_nohp:\nibu_nama:\nibu_keadaan:\nibu_agama:\nibu_kewarganegaraan:\nibu_pendidikan:\nibu_pekerjaan:\nibu_penghasilan:\nibu_alamat:\nibu_rt:\nibu_rw:\nibu_desa:\nibu_kecamatan:\nibu_kabupaten:\nibu_provinsi:\nibu_kodepos:\nibu_nohp:\nwali_nama:\nwali_keadaan:\nwali_agama:\nwali_kewarganegaraan:\nwali_pendidikan:\nwali_pekerjaan:\nwali_penghasilan:\nwali_alamat:\nwali_rt:\nwali_rw:\nwali_desa:\nwali_kecamatan:\nwali_kabupaten:\nwali_provinsi:\nwali_kodepos:\nwali_nohp:\n";
                \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Insert Data Siswa',  $pesan));
                break;
            case 'Export Data':
                // Export Data / Operator / Siswa#Guru / id:nama_siswa:nis:kelas_id
                $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                $selectData = ['id', 'nama_siswa', 'kelas_id', 'nis', 'nisn', 'tanggal_lahir'];
                $selectData = explode(':', $pesan[3]);
                // buat header otomatis dari $selectData
                $headers = collect($selectData)->map(function ($col) {
                    $col = preg_replace('/_id$/', '', $col); // hapus suffix _id
                    $col = str_replace('_', ' ', $col);      // ganti _ jadi spasi
                    return ucwords($col);                    // kapital
                })->toArray();
                if (!isset($pesan[2])) {
                    $PesanKirim =
                        'Maaf belum ada data yang ditentukan';
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Informasi Data', $PesanKirim));
                }
                // ganti "Id" jadi "No"
                $headers[0] = 'No';
                if ($pesan[2] === 'Siswa') {
                    // ambil data
                    $students = Detailsiswa::with('KelasOne')
                        ->select($selectData)
                        ->where('status_siswa', 'aktif')
                        ->orderBy('kelas_id', 'ASC')
                        ->get()
                        ->values() // reset index biar map dapet index urut
                        ->map(function ($s, $i) use ($selectData) {
                            return collect($selectData)->map(function ($col) use ($s, $i) {
                                if ($col === 'id') {
                                    return $i + 1; // nomor urut manual
                                }
                                if ($col === 'kelas_id') {
                                    return $s->KelasOne?->kelas; // mapping relasi
                                }
                                return $s->$col;
                            })->toArray();
                        })
                        ->toArray();

                    // simpan excel

                    $Path = base_path('whatsapp/export');
                    $filePath = export_excel(
                        'siswa.xlsx',
                        $headers, // otomatis dari $selectData
                        $students,
                        'store',
                        $Path
                    );
                    sleep(10);
                    // dd("File tersimpan di: " . $filePath);
                    $filename = 'siswa.xlsx';
                    $filePath = base_path('whatsapp/export/' . $filename);
                    $caption = "isi data";
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } elseif ($pesan[2] === 'Guru') {
                    $dataGuru = Detailguru::select($selectData)
                        ->whereNotIn('id', [1, 2, 3])
                        ->get()
                        ->values() // reset index biar map dapet index urut
                        ->map(function ($s, $i) use ($selectData) {
                            return collect($selectData)->map(function ($col) use ($s, $i) {
                                if ($col === 'id') {
                                    return $i + 1; // nomor urut manual
                                }
                                return $s->$col;
                            })->toArray();
                        })->toArray();
                    // simpan excel
                    $Path = base_path('whatsapp/export');
                    $filename = "Data {$pesan[2]}.xlsx";
                    $filePath = export_excel(
                        $filename,
                        $headers, // otomatis dari $selectData
                        $dataGuru,
                        'store',
                        $Path
                    );
                    $filePath = base_path('whatsapp/export/' . $filename);
                    $caption =
                        "Berikut data excel yang diminta";
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Data Pemintaan', $caption), $filePath);
                } else {
                    $PesanKirim =
                        'Maaf belum ada data yang ditentukan';
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Informasi Data', $PesanKirim));
                }

                break;
            case 'Export Alumni':
                // Case / Operator / Alumni / tahun /nama_siswa
                // Export Alumni / Operator / Alumni / 2024 / nama_siswa
                $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                $selectData = explode(':', $pesan[4]);
                $tapel = Etapel::where('tapel', $pesan[3])->max('id');


                // buat header otomatis dari $selectData
                $headers = collect($selectData)->map(function ($col) {
                    $col = preg_replace('/_id$/', '', $col); // hapus suffix _id
                    $col = str_replace('_', ' ', $col);      // ganti _ jadi spasi
                    return ucwords($col);                    // kapital
                })->toArray();
                if (!isset($pesan[2])) {
                    $PesanKirim =
                        'Maaf belum ada data yang ditentukan';
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Informasi Data', $PesanKirim));
                }
                $students = Detailsiswa::with('KelasOne')
                    ->select($selectData)
                    ->where('status_siswa', 'lulus')
                    ->where('tahun_lulus', $tapel)
                    ->get()
                    ->values() // reset index biar map dapet index urut
                    ->map(function ($s, $i) use ($selectData) {
                        return collect($selectData)->map(function ($col) use ($s, $i) {
                            if ($col === 'id') {
                                return $i + 1; // nomor urut manual
                            }
                            if ($col === 'kelas_id') {
                                return $s->KelasOne?->kelas; // mapping relasi
                            }
                            return $s->$col;
                        })->toArray();
                    })
                    ->toArray();

                $Path = base_path('whatsapp/export');
                $filePath = export_excel(
                    'alumni.xlsx',
                    $headers, // otomatis dari $selectData
                    $students,
                    'store',
                    $Path
                );
                sleep(10);
                // dd("File tersimpan di: " . $filePath);
                $filename = 'alumni.xlsx';
                $filePath = base_path('whatsapp/export/' . $filename);
                $caption = "isi data";
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                break;
            case 'Export Guru':
                // Case / Operator / Guru / tahun

                break;
            case 'Cetak Dok':
                $pesan = explode("/", $message);
                $terakhir = end($pesan);
                if ($terakhir === "Cetak") {
                    $filename = "Data Guru.xlsx";
                    $filePath = base_path('whatsapp/export/' . $filename);
                    $result = print_docx($filePath);
                    $PesanKirim =
                        "Data telah dicetak pastikan printer terhubung dan sesuai \n" .
                        "\n\n";
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('judul', $PesanKirim));
                } else {
                    echo "Bukan Cetak, tapi $terakhir";
                }
                return response()->json([
                    'status' => 'ok',
                    'message' => $result,
                ]);
                break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
