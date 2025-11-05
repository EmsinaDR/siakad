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
                break;
            // Analisa
            case 'Sekolah Asal':
                // Sekolah Asal / Operator / tingkat
                $pesan = explode('/', $message);
                if (isset($pesan[2])) {
                    $SekolahAsal = Detailsiswa::select('namasek_asal', DB::raw('count(*) as total'))
                        ->where('status_siswa', 'aktif')
                        ->where('tingkat_id', $pesan[2])
                        ->groupBy('namasek_asal')
                        ->orderBy('namasek_asal')
                        ->get();

                    // Total siswa dari semua sekolah asal
                    $total_siswa = $SekolahAsal->sum('total'); // 🔥 ini jumlah siswa sebenarnya
                    // Total sekolah (jumlah grup)
                    $total_sekolah = $SekolahAsal->count();    // 🔹 ini jumlah nama sekolah unik
                } else {
                    $SekolahAsal = Detailsiswa::select('namasek_asal', DB::raw('count(*) as total'))
                        ->where('status_siswa', 'aktif')
                        ->groupBy('namasek_asal')
                        ->orderBy('namasek_asal')
                        ->get();
                    // Total siswa dari semua sekolah asal
                    $total_siswa = $SekolahAsal->sum('total'); // 🔥 ini jumlah siswa sebenarnya
                    // Total sekolah (jumlah grup)
                    $total_sekolah = $SekolahAsal->count();    // 🔹 ini jumlah nama sekolah unik
                }
                $dataSekolahAsal =
                    "Berikut data sekolah asal siswa yang tersedia :\n" .
                    "Data ini bisa menjadi rekomendasi memaksimalkan PPDB berikutnya sebagai pertimbangan sosialisasi.\n";
                foreach ($SekolahAsal as $index => $item) {
                    $sekolah_asal = $item->namasek_asal ?? '*Tidak Diketahui*';
                    $dataSekolahAsal .= $index + 1 . ". {$sekolah_asal} : {$item->total}\n";
                }
                $dataSekolahAsal .=
                    "\n" . str_repeat("─", 25) . "\n" .
                    "Jumlah total siswa : {$total_siswa} Siswa\n" .
                    "Jumlah total sekolah : {$total_sekolah} Sekolah\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Sekolah Asal Siswa', $dataSekolahAsal));
                break;
            case 'Compare Sekolah Asal':
                $pesan = explode('/', $message);
                $tingkatList = isset($pesan[2]) ? array_map('trim', explode(':', $pesan[2])) : [];

                if (count($tingkatList) > 1) {
                    $compareData = [];

                    // Ambil data sekolah per tingkat
                    foreach ($tingkatList as $tingkat) {
                        $data = Detailsiswa::select('namasek_asal', DB::raw('count(*) as total'))
                            ->where('status_siswa', 'aktif')
                            ->where('tingkat_id', $tingkat)
                            ->groupBy('namasek_asal')
                            ->get()
                            ->pluck('total', 'namasek_asal');

                        $compareData[$tingkat] = $data;
                    }

                    $allSchools = collect($compareData)->flatMap(fn($v) => $v->keys())->unique();
                    $dataSekolahAsal = "📊 *Perbandingan Jumlah Siswa per Sekolah Asal*\n";
                    $dataSekolahAsal .= "Tingkat dibandingkan (angkatan lama → baru): " . implode(' → ', $tingkatList) . "\n\n";

                    // 💡 Loop per sekolah
                    foreach ($allSchools as $school) {
                        $dataSekolahAsal .= "🏫 {$school}\n";
                        $previous = null;

                        foreach ($tingkatList as $tingkat) {
                            $jumlah = $compareData[$tingkat][$school] ?? 0;

                            if ($previous !== null) {
                                $selisih = $jumlah - $previous;

                                if ($selisih < 0) {
                                    $trend = "📉 Penurunan (" . abs($selisih) . ")";
                                } elseif ($selisih > 0) {
                                    $trend = "📈 Kenaikan (+{$selisih})";
                                } else {
                                    $trend = "➖ Tetap";
                                }

                                $dataSekolahAsal .= "   • Tingkat {$tingkat} : {$jumlah} siswa ({$trend})\n";
                            } else {
                                $dataSekolahAsal .= "   • Tingkat {$tingkat} : {$jumlah} siswa\n";
                            }

                            $previous = $jumlah;
                        }
                        $dataSekolahAsal .= "\n";
                    }

                    // 🔥 Tambahan total siswa & jenis kelamin per tingkat
                    $summary = [];
                    foreach ($tingkatList as $tingkat) {
                        $total = Detailsiswa::where('status_siswa', 'aktif')->where('tingkat_id', $tingkat)->count();
                        $laki = Detailsiswa::where('status_siswa', 'aktif')->where('tingkat_id', $tingkat)->where('jenis_kelamin', 'Laki-laki')->count();
                        $perempuan = Detailsiswa::where('status_siswa', 'aktif')->where('tingkat_id', $tingkat)->where('jenis_kelamin', 'Perempuan')->count();

                        $summary[$tingkat] = [
                            'total' => $total,
                            'l' => $laki,
                            'p' => $perempuan,
                        ];

                        $dataSekolahAsal .= "📘 Tingkat {$tingkat} → Total: {$total} siswa (L: {$laki}, P: {$perempuan})\n";
                    }

                    // 🔄 Bandingkan total antar tingkat (terakhir)
                    if (count($tingkatList) == 2) {
                        [$tingkatLama, $tingkatBaru] = $tingkatList;

                        $diffTotal = $summary[$tingkatBaru]['total'] - $summary[$tingkatLama]['total'];
                        $diffL = $summary[$tingkatBaru]['l'] - $summary[$tingkatLama]['l'];
                        $diffP = $summary[$tingkatBaru]['p'] - $summary[$tingkatLama]['p'];

                        $dataSekolahAsal .= "\n" . str_repeat('─', 30) . "\n";

                        $dataSekolahAsal .= "📊 *Perbandingan Akhir (Total Siswa)*\n";
                        $dataSekolahAsal .= "   👦 Laki-laki: " . ($diffL > 0 ? "📉 {$diffL}" : ($diffL < 0 ? "📈 " . abs($diffL) : "➖ Tetap")) . "\n";
                        $dataSekolahAsal .= "   👧 Perempuan: " . ($diffP > 0 ? "📉 {$diffP}" : ($diffP < 0 ? "📈 " . abs($diffP) : "➖ Tetap")) . "\n";
                        $dataSekolahAsal .= "   👥 Total: " . ($diffTotal > 0 ? "📉 {$diffTotal}" : ($diffTotal < 0 ? "📈 " . abs($diffTotal) : "➖ Tetap")) . "\n";
                    }

                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage(
                        $sessions,
                        $NoRequest,
                        format_pesan('📊 Data Perbandingan Sekolah Asal', $dataSekolahAsal)
                    );
                }
                break;



            case 'Hobi':
                // Hobi / Operator / tingkat (opsional)
                $pesan = explode('/', $message);

                if (isset($pesan[2])) {
                    $tingkatFilter = explode(':', $pesan[2]);
                    $tingkatFilter = array_map('trim', $tingkatFilter);

                    $DataHobi = Detailsiswa::select('hobi', DB::raw('count(*) as total'))
                        ->where('status_siswa', 'aktif')
                        ->whereNotNull('hobi')
                        ->whereIn('tingkat_id', $tingkatFilter)
                        ->groupBy('hobi')
                        ->orderBy('hobi', 'ASC')
                        ->get();
                } else {
                    // Jika tanpa tingkat_id
                    $DataHobi = Detailsiswa::select('hobi', DB::raw('count(*) as total'))
                        ->where('status_siswa', 'aktif')
                        ->whereNotNull('hobi')
                        ->groupBy('hobi')
                        ->orderBy('hobi', 'ASC')
                        ->get();
                }

                // Format pesan hasil
                $isiHobi =
                    "🎯 *Data Hobi Siswa Aktif*\n\n" .
                    "Data ini sangat direkomendasikan untuk sekolah gunakan dalam menentukkan pengadaan eskul sesuai minat dan bakat siswa dalam pengembangan sekolah diluar Intra atau sebagai ekstra / kokuler\n" .
                    "Selain itu data ini bisa jadi rekomendasi untuk diajukan sebagai peserta lomba\n" .
                    "\n\n";
                foreach ($DataHobi as $index => $item) {
                    $hobi = $item->hobi ?? '*Tidak Diketahui*';
                    $isiHobi .= ($index + 1) . ". {$hobi} : {$item->total} Siswa\n";
                }

                if ($DataHobi->isEmpty()) {
                    $isiHobi .= "⚠️ Tidak ada data hobi yang ditemukan.\n";
                }

                $result = \App\Models\Whatsapp\WhatsApp::sendMessage(
                    $sessions,
                    $NoRequest,
                    format_pesan('Data Hobi Siswa', $isiHobi)
                );
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
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Sekolah Usia Siswa', $pesan));


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
                    $caption = "Berikut hasil data file berdasarkan data yang diminta";
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb("Format Data Excel", $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
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








            case 'Export Data Emis':
                // Export Data Emis / Operator / Siswa#Guru


                $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                $selectData = ['id', 'nama_siswa', 'kelas_id', 'nis', 'nisn', 'tanggal_lahir'];
                if (isset($pesan[3])) {
                    $selectData = explode(':', $pesan[3]);
                } else {
                    $data = "id:kelas_id:nis:nik:nisn:nama_siswa:jenis_kelamin:tempat_lahir:tanggal_lahir:namasek_asal:alamat_siswa:kecamatan:desa:kode_pos:nokk:ayah_nama:ayah_tempat_lahir:ayah_tanggal_lahir:ayah_nik:ayah_pekerjaan:ibu_nama:ibu_tempat_lahir:ibu_tanggal_lahir:ibu_nik:ibu_pekerjaan:wali_nama:wali_tempat_lahir:wali_tanggal_lahir:wali_nik";
                    $selectData = explode(':',  $data);
                }
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
                $Identitas = getIdentitas();
                if ($pesan[2] === 'Siswa') {
                    // ambil data
                    $students = Detailsiswa::with('KelasOne')
                        ->select($selectData)
                        ->where('status_siswa', 'aktif')
                        ->orderBy('kelas_id', 'ASC')
                        ->get()
                        ->values() // reset index biar map dapet index urut
                        ->map(function ($s, $i) use ($selectData, $Identitas) {
                            return collect($selectData)->map(function ($col) use ($s, $i, $Identitas) {
                                // default value
                                $value = $s->{$col} ?? '';

                                // special handling per column
                                if ($col === 'id') {
                                    return $i + 1;
                                }

                                if ($col === 'kelas_id') {
                                    return $s->KelasOne?->kelas ?? '';
                                }

                                if ($col === 'nis') {
                                    // gabungkan prefix nsm dari Identitas (aman dengan null coalescing)
                                    $value = ($Identitas->nsm ?? '') . ($s->nis ?? '');
                                }

                                // untuk kolom yang harus dipaksa menjadi TEXT agar Excel tidak ubah ke E+...
                                $asTextCols = ['nik', 'nisn', 'nokk', 'nis'];
                                if (in_array($col, $asTextCols)) {
                                    // pastikan nilai string dan tambahkan apostrof di depan
                                    return "'" . (string) $value;
                                }

                                // default return
                                return $value;
                            })->toArray();
                        })


                        ->toArray();

                    // simpan excel

                    $Path = base_path('whatsapp/export');
                    $filePath = export_excel(
                        'Data Emis.xlsx',
                        $headers, // otomatis dari $selectData
                        $students,
                        'store',
                        $Path
                    );
                    sleep(10);
                    // dd("File tersimpan di: " . $filePath);
                    $filename = 'Data Emis.xlsx';
                    $filePath = base_path('whatsapp/export/' . $filename);
                    $caption = "Berikut ini excel data emis yang diminta";
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Data Emis', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
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
            case 'Pekerjaan':
                // Format:
                // Pekerjaan/Operator/Ibu
                // Pekerjaan/Operator/Ibu/8
                // Pekerjaan/Operator/Ibu/7:8:9
                // Pekerjaan/Operator/Ayah/9

                $pesan = explode('/', $message);
                $orang = strtolower($pesan[2] ?? '');
                $tingkatFilter = isset($pesan[3]) ? explode(':', $pesan[3]) : [];

                // Tentukan kolom pekerjaan
                $pekerjaanField = $orang === 'ibu' ? 'ibu_pekerjaan' : 'ayah_pekerjaan';

                if (empty($orang)) {
                    // tampilkan gabungan Ayah & Ibu
                    $isiPesan = "📊 *Data Pekerjaan Ayah & Ibu (Keseluruhan)*\n\n";

                    foreach (['ayah_pekerjaan' => 'Ayah', 'ibu_pekerjaan' => 'Ibu'] as $field => $label) {
                        $Caris = Detailsiswa::query()
                            ->where('status_siswa', 'aktif')
                            ->whereNotNull($field)
                            ->selectRaw("$field, COUNT(*) as jumlah")
                            ->groupBy($field)
                            ->orderBy($field)
                            ->get();

                        if ($Caris->isEmpty()) continue;

                        $isiPesan .= "👨‍👩‍👧 *Pekerjaan {$label}:*\n";
                        foreach ($Caris as $item) {
                            $pekerjaan = $item->$field ?: '-';
                            $jumlah = $item->jumlah;
                            $isiPesan .= "   • {$pekerjaan} → *{$jumlah} siswa*\n";
                        }
                        $isiPesan .= "\n";
                    }

                    $pesanKiriman = format_pesan("📋 Statistik Pekerjaan Orang Tua", $isiPesan);
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                    break;
                }


                // Kalau ada filter tingkat (7:8:9)
                if (!empty($tingkatFilter)) {
                    $isiPesan = "📊 *Data Pekerjaan " . ucfirst($orang) . "*\n\n";

                    foreach ($tingkatFilter as $tingkat) {
                        $Caris = Detailsiswa::query()
                            ->where('status_siswa', 'aktif')
                            ->where('tingkat_id', $tingkat)
                            ->whereNotNull($pekerjaanField)
                            ->selectRaw("$pekerjaanField, COUNT(*) as jumlah")
                            ->groupBy($pekerjaanField)
                            ->orderBy($pekerjaanField)
                            ->get();

                        if ($Caris->isEmpty()) continue;

                        $isiPesan .= "📘 *Tingkat $tingkat*\n";
                        foreach ($Caris as $item) {
                            $pekerjaan = $item->$pekerjaanField ?: '-';
                            $jumlah = $item->jumlah;
                            $isiPesan .= "👩‍💼 $pekerjaan → *$jumlah siswa*\n";
                        }
                        $isiPesan .= "\n";
                    }

                    if (trim($isiPesan) === "📊 *Data Pekerjaan " . ucfirst($orang) . "*") {
                        $isiPesan .= "⚠️ Tidak ada data ditemukan.";
                    }
                } else {
                    // Kalau gak ada filter tingkat, tampilkan keseluruhan
                    $Caris = Detailsiswa::query()
                        ->where('status_siswa', 'aktif')
                        ->whereNotNull($pekerjaanField)
                        ->selectRaw("$pekerjaanField, COUNT(*) as jumlah")
                        ->groupBy($pekerjaanField)
                        ->orderBy($pekerjaanField)
                        ->get();

                    if ($Caris->isEmpty()) {
                        $isiPesan = "⚠️ Tidak ada data ditemukan.";
                    } else {
                        $isiPesan = "📊 *Data Pekerjaan " . ucfirst($orang) . "*\n\n";
                        foreach ($Caris as $item) {
                            $pekerjaan = $item->$pekerjaanField ?: '-';
                            $jumlah = $item->jumlah;
                            $isiPesan .= "👩‍💼 $pekerjaan → *$jumlah siswa*\n";
                        }
                        $isiPesan .= "\n─────────────────────────\nTotal Jenis: *" . $Caris->count() . "*";
                    }
                }

                // Bungkus & kirim
                $pesanKiriman = format_pesan("📋 Statistik Pekerjaan " . ucfirst($orang), $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Penghasilan':
                // Format:
                // Penghasilan/Operator/Ibu
                // Penghasilan/Operator/Ayah/7
                // Penghasilan/Operator/Ibu/7:8:9

                $pesan = explode('/', $message);
                $orang = strtolower($pesan[2] ?? '');
                $tingkatFilter = isset($pesan[3]) ? explode(':', $pesan[3]) : [];

                // Tentukan kolom penghasilan
                $penghasilanField = $orang === 'ibu' ? 'ibu_penghasilan' : 'ayah_penghasilan';

                // Judul pesan
                $judul = "📊 Statistik Penghasilan " . ucfirst($orang);
                $isiPesan = '';

                // Kalau ada filter tingkat (contoh: 7:8:9)
                if (!empty($tingkatFilter)) {
                    $isiPesan .= "*$judul per Tingkat*\n\n";

                    foreach ($tingkatFilter as $tingkat) {
                        $Caris = Detailsiswa::query()
                            ->where('status_siswa', 'aktif')
                            ->where('tingkat_id', $tingkat)
                            ->whereNotNull($penghasilanField)
                            ->selectRaw("$penghasilanField, COUNT(*) as jumlah")
                            ->groupBy($penghasilanField)
                            ->orderBy($penghasilanField)
                            ->get();

                        if ($Caris->isEmpty()) continue;

                        $isiPesan .= "💰 *Tingkat $tingkat*\n";
                        foreach ($Caris as $item) {
                            $penghasilan = $item->$penghasilanField ?: '-';
                            $jumlah = $item->jumlah;
                            $isiPesan .= "👛 $penghasilan → *$jumlah siswa*\n";
                        }
                        $isiPesan .= "\n";
                    }

                    if (trim($isiPesan) === "*$judul per Tingkat*") {
                        $isiPesan .= "⚠️ Tidak ada data ditemukan.";
                    }
                } else {
                    // Kalau tanpa filter tingkat
                    $Caris = Detailsiswa::query()
                        ->where('status_siswa', 'aktif')
                        ->whereNotNull($penghasilanField)
                        ->selectRaw("$penghasilanField, COUNT(*) as jumlah")
                        ->groupBy($penghasilanField)
                        ->orderBy($penghasilanField)
                        ->get();

                    if ($Caris->isEmpty()) {
                        $isiPesan = "⚠️ Tidak ada data penghasilan $orang ditemukan.";
                    } else {
                        $isiPesan .= "$judul (Semua Tingkat)\n\n";
                        foreach ($Caris as $item) {
                            $penghasilan = $item->$penghasilanField ?: '-';
                            $jumlah = $item->jumlah;
                            $isiPesan .= "👛 $penghasilan → *$jumlah siswa*\n";
                        }
                        $isiPesan .= "\n─────────────────────────\nTotal Jenis: *" . $Caris->count() . "*";
                    }
                }

                // Kirim via WhatsApp
                $pesanKiriman = format_pesan($judul, $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;


            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
