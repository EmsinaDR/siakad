<?php

use Carbon\Carbon;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Identitas;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Siswa\Detailsiswa;

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_Wali_KelasHelper
    |----------------------------------------------------------------------
    |
    Data Update Terkait Wali Kelas
    Data No Absen
    Data Piket
    Data Struktur Organisasi
*/

if (!function_exists('Auto_Reply_Wali_KelasHelper')) {
    function Auto_Reply_Wali_KelasHelper($Kode, $NoRequest, $message)
    { {
            $Identitas = Identitas::first();
            $data = explode('/', $message);
            $sessions = config('whatsappSession.IdWaUtama');
            switch ($Kode) {
                case 'Export Absensi':
                    // Export Absensi / Walkes/VII A
                    $tapel = tapel();
                    //$tapel->id
                    //where('tapel_id', $tapel->id)->

                    $Kelas = Ekelas::where('kelas', $data[2])->where('tapel_id', $tapel->id)->first();
                    $filename = ExportAbsensiKelas($Kelas->id, $NoRequest);
                    $sessions = config('whatsappSession.IdWaUtama');
                    $tapelPelajaran = $tapel->tapel . "/" . $tapel->tapel + 1;
                    $caption =
                        "Berikut absensi untuk {$Kelas->kelas} \n" .
                        "Tahun Pelajaran {$tapelPelajaran} \n" .
                        " \n" .
                        "\n";

                    // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Export Absensi Kelas', $PesanKirim));
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan('Export Absensi Kelas', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                    break;
                case 'Jadwal Piketx':
                    // Jadwal Piket / Walkes/VII A
                    $tapel = tapel();
                    $Kelas = Ekelas::where('kelas', $data[2])->where('tapel_id', $tapel->id)->first();
                    $tapelPelajaran = $tapel->tapel . "/" . $tapel->tapel + 1;
                    $caption =
                        "Berikut Export Jadwal Piket Kelas untuk {$Kelas->kelas} \n" .
                        "Tahun Pelajaran {$tapelPelajaran} \n" .
                        " \n" .
                        "\n";

                    // ProsesBuat Jadwal Piket
                    $filename = ExportAbsensiKelas($Kelas->id, $NoRequest);
                    $sessions = config('whatsappSession.IdWaUtama');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan('Export Jadwal Piket Kelas', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                    break;

                case 'Export Absensix':
                    // Export Absensi / Walkes / tapel / smt / kelas
                    $kelas_id = 4;
                    $sessions = config('whatsappSession.IdWaUtama');
                    $PesanKirim =
                        "isiPesan \n" .
                        "\n";

                    // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Export Absensi Kelas', $caption));
                    // 🔹 Ambil data rekap absensi dari helper
                    $rekap = rekap_absensi_kelas($kelas_id);

                    // 🔹 Ambil identitas sekolah (nama, alamat, logo, dsb)
                    $dataIdentitas = DataIdentitas();

                    // 🔹 Data tambahan untuk header laporan
                    $dataTambahan = [
                        'judul' => 'Rekapitulasi Absensi Siswa',
                        'subjudul' => 'Kelas ID: ' . $kelas_id,
                        'tahun' => $rekap['tahun'],
                        'semester' => $rekap['semester'],
                        'tanggal_cetak' => now()->translatedFormat('d F Y'),
                    ];

                    // 🔹 Satukan semua data untuk dikirim ke view
                    $data = array_merge($dataTambahan, [
                        'DataAbsen' => $rekap['datas'],
                        'bulanArray' => $rekap['bulanArray']
                    ], $dataIdentitas);

                    // 🔹 Tentukan lokasi folder dan view yang akan dirender
                    $folder = public_path('temp/export/absensi');
                    $view = 'role.walkes.export-pdf-rekap-absensi';

                    // 🔹 Nama file PDF
                    $kelas_nama = optional(Ekelas::find($kelas_id))->nama ?? 'Tanpa Nama';
                    $filename = 'Rekap Absensi Kelas ' . str_replace(' ', '_', $kelas_nama) . ' - Semester ' . $rekap['semester'];

                    // 🔹 Render & simpan file PDF menggunakan helper DomExport()
                    DomExport($filename, $data, $view, $folder);

                    // // 🔹 Copy ke folder WA agar bisa dikirim via gateway
                    // CopyFileWa($filename . '.pdf', 'temp/export/absensi');

                    // // Tunggu sebentar sebelum dikirim (kalau ada mekanisme async)
                    // sleep(5);

                    // // 🔹 Tentukan path akhir file untuk WhatsApp Gateway
                    // $filePath = base_path('whatsapp/uploads/' . $filename . '.pdf');

                    // // ✅ Balikkan response (atau lanjut ke logika kirim WA)
                    // return response()->json([
                    //     'status' => 'success',
                    //     'message' => 'PDF berhasil diekspor',
                    //     'path' => $filePath
                    // ]);
                    break;
                case 'Export Absensie':
                    // Export Absensi / tapel / smt / kelas
                    break;
                case 'Export Data':
                    // Contoh pesan WA:
                    // Export Data / Walkes / VII A
                    // atau
                    // Export Data / Walkes / VII A / nama_siswa:hobi:tanggal_lahir
                    // Export Data / Walkes / VII A / id:nama_siswa:nis:kelas_id:alamat_siswa:ayah_nama:ibu_nama

                    // 1️⃣ Pecah pesan berdasarkan '/' lalu trim spasi berlebih di tiap elemen
                    $pesan = array_map('trim', explode('/', $message));

                    // 2️⃣ Pastikan format minimal: Export Data / Walkes / <kelas>
                    if (!isset($pesan[2])) {
                        $PesanKirim = 'Format salah! Gunakan contoh: Export Data / Walkes / VII A / id:nama_siswa:nis:kelas_id:alamat_siswa:ayah_nama:ibu_nama';
                        \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Kesalahan', $PesanKirim));
                        return false;
                    }

                    // 3️⃣ Ambil data kelas berdasarkan nama
                    $kelas = Ekelas::where('kelas', $pesan[2])->first();
                    if (!$kelas) {
                        $PesanKirim = "Kelas '{$pesan[2]}' tidak ditemukan di database.";
                        \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Kesalahan', $PesanKirim));
                        return false;
                    }


                    // 4️⃣ Tentukan kolom yang akan diekspor
                    $selectData = ['id', 'nama_siswa', 'kelas_id', 'nis', 'nisn', 'tanggal_lahir'];
                    if (isset($pesan[3]) && !empty(trim($pesan[3]))) {
                        $selectData = explode(':', trim($pesan[3]));
                    } else {
                        // default kolom lengkap
                        $data = "id:kelas_id:nis:nik:nisn:nama_siswa:jenis_kelamin:tempat_lahir:tanggal_lahir:namasek_asal:alamat_siswa:kecamatan:desa:kode_pos:nokk:ayah_nama:ayah_tempat_lahir:ayah_tanggal_lahir:ayah_nik:ayah_pekerjaan:ibu_nama:ibu_tempat_lahir:ibu_tanggal_lahir:ibu_nik:ibu_pekerjaan:wali_nama:wali_tempat_lahir:wali_tanggal_lahir:wali_nik";
                        $data = "id:kelas_id:nis:nik:nisn:nama_siswa:jenis_kelamin:tempat_lahir:tanggal_lahir:namasek_asal:alamat_siswa:kecamatan:desa:kode_pos:nokk";
                        $selectData = explode(':', $data);
                    }

                    // 5️⃣ Buat header otomatis dari nama kolom
                    $headers = collect($selectData)->map(function ($col) {
                        $col = preg_replace('/_id$/', '', $col); // hapus akhiran _id
                        $col = str_replace('_', ' ', $col);      // ubah _ jadi spasi
                        return ucwords($col);                    // kapital tiap kata
                    })->toArray();
                    $headers[0] = 'No'; // kolom pertama jadi “No” bukan “Id”

                    $Identitas = getIdentitas();

                    // 6️⃣ Ambil data siswa berdasarkan kelas
                    $students = Detailsiswa::with('KelasOne')
                        ->select($selectData)
                        ->where('status_siswa', 'aktif')
                        ->where('kelas_id', $kelas->id)
                        ->orderBy('nama_siswa', 'ASC')
                        ->get()
                        ->values()
                        ->map(function ($s, $i) use ($selectData, $Identitas) {
                            return collect($selectData)->map(function ($col) use ($s, $i, $Identitas) {
                                $value = $s->{$col} ?? '';

                                // ubah ID jadi nomor urut
                                if ($col === 'id') return $i + 1;

                                // ubah kelas_id jadi nama kelas
                                if ($col === 'kelas_id') return $s->KelasOne?->kelas ?? '';

                                // gabungkan prefix NSM untuk NIS
                                if ($col === 'nis') {
                                    $value = $s->nis ?? '';
                                    // $value = ($Identitas->nsm ?? '') . ($s->nis ?? '');
                                }

                                // pastikan beberapa kolom tetap dianggap teks di Excel
                                $asTextCols = ['nik', 'nisn', 'nokk', 'nis'];
                                if (in_array($col, $asTextCols)) {
                                    return (string) $value;
                                }

                                return $value;
                            })->toArray();
                        })
                        ->toArray();

                    // 7️⃣ Simpan ke file Excel
                    $Path = base_path('whatsapp/export');
                    $filename = 'Export Data ' . str_replace(' ', '_', $pesan[2]) . '.xlsx';
                    $filePath = export_excel($filename, $headers, $students, 'store', $Path);

                    sleep(10); // beri waktu agar file siap dikirim

                    // 8️⃣ Kirim file ke WhatsApp
                    $filePath = base_path('whatsapp/export/' . $filename);
                    $caption = "Berikut ini file Excel Export Data kelas {$pesan[2]} yang diminta.";
                    \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Data Emis', $caption), $filePath);

                    break;
                case 'Jadwal Piket':
                    // Jadwal Piket / Walkes / VII A / 2
                    $tapel = tapel();
                    $Identitas = getIdentitas();
                    $pesan = explode('/', $message);
                    $kelasNama = trim($pesan[2]);
                    $tanggal_ttd = \Carbon\Carbon::now()->addDays(2)->translatedformat('d F Y');

                    $kelas = Ekelas::with('Guru')->where('tapel_id', $tapel->id)
                        ->where('kelas', $kelasNama)
                        ->first();

                    if (!$kelas) {
                        $pesanKiriman = format_pesan('Kesalahan', "Kelas $kelasNama tidak ditemukan.");
                        \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                        break;
                    }

                    $Siswa = Detailsiswa::SiswaAktif()->where('kelas_id', $kelas->id)->get();

                    // Mapping DB hari -> field template Word
                    $hariTemplate = [
                        'Senin'   => 'senin',
                        'Selasa'  => 'selasa',
                        'Rabu'    => 'rabu',
                        'Kamis'   => 'kamis',
                        "Jum'at"  => 'jumat',
                        'Sabtu'   => 'sabtu',
                    ];

                    // Inisialisasi array values
                    $walkes = $kelas->Guru->nama_guru . ',' . $kelas->Guru->gelar ?? '-';
                    $values = [
                        'kelas' => $kelasNama,
                        'tapel' => $tapel->tapel . ' - ' . ($tapel->tapel + 1),
                        'nama_walikelas' => $walkes ?? '-',
                        'nip_walikelas' => $kelas->Guru->nip ?? '-',
                        'kecamatan' => $Identitas->kecamatan ?? '-',
                        'tanggal_ttd' => $tanggal_ttd ?? '-',
                    ];

                    foreach ($hariTemplate as $field) {
                        $values[$field] = '';
                    }

                    // Isi siswa per hari
                    foreach ($Siswa as $s) {
                        $dbHari = $s->piket_kelas; // misal "Jum'at"
                        $nama   = $s->nama_siswa;

                        if (isset($hariTemplate[$dbHari])) {
                            $field = $hariTemplate[$dbHari]; // key Word
                            $values[$field] .= $nama . "<w:br/>";
                        }
                    }

                    // Render template Word
                    $filename = 'Jadwal Piket ' . $pesan[2] . '.docx';
                    $file = TemplateWordHelperx([
                        'template' => public_path('template/template_walkes_jadwal_piket.docx'),
                        'output'   => base_path('whatsapp/uploads/' . $filename),
                        'values'   => $values,
                        'images' => [
                            'qrcode' => [
                                'path' => qrttd("Jadwal Piket Kelas {$pesan[2]}\n{$values['tapel']}"), // <-- Base64 langsung
                                'width' => 150,
                                'height' => 150,
                            ],
                            'ttd_kepala' => [
                                'path' => public_path('img/template/ttd/kepala.png'),
                                'width' => 200,
                                'height' => 200,
                                'positioning' => 'absolute',  // floating
                                'marginTop' => 10,            // jarak dari atas
                                'marginLeft' => 0,            // jarak dari kiri
                                'behindText' => true,         // supaya tidak merubah layout tabel
                            ],

                        ],
                    ]);
                    // $result = CopyFileWa($filename, 'template');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $caption = "Jadwal Piket kelas $kelasNama berhasil dibuat.\nSilakan cek file: ";
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp

                    hapusFileWhatsApp($filePath, $filename);
                    // hapusFileWhatsApp($filePath, $filename);
                    break;

                case 'Data Siswa':
                    // Data Siswa / Walkes / VII A / 2
                    $tapel = tapel();
                    $Identitas = getIdentitas();
                    $pesan = explode('/', $message);
                    $kelasNama = trim($pesan[2]);
                    $hariTambahan = isset($pesan[3]) ? (int)$pesan[3] : 0;

                    // Ambil kelas aktif beserta guru
                    $kelas = Ekelas::kelasAktif()->with('Guru')
                        ->where('kelas', $kelasNama)
                        ->first();

                    if (!$kelas) {
                        $pesanKiriman = format_pesan('Kesalahan', "Kelas $kelasNama tidak ditemukan.");
                        \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                        break;
                    }

                    // Ambil siswa aktif
                    $Siswa = Detailsiswa::SiswaAktif()
                        ->where('kelas_id', $kelas->id)
                        ->get();

                    // Hitung tanggal TTD sekali saja
                    $tanggal_ttd = Carbon::now()->addDays($hariTambahan)
                        ->translatedFormat('d F Y');

                    // Nama file output
                    $filename = 'Data Siswa ' . $kelasNama . '.docx';
                    $outputPath = base_path('whatsapp/uploads/' . $filename);

                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('template/template_walkes_data_siswa.docx'));

                    // Set field umum
                    $templateProcessor->setValue("kelas", $kelasNama);
                    $templateProcessor->setValue("semester", $tapel->semester);
                    $templateProcessor->setValue("tapel", ($tapel->tapel) . '-' . ($tapel->tapel + 1));
                    $templateProcessor->setValue("kecamatan", $Identitas->kecamatan ?? '-');
                    $templateProcessor->setValue("walkes", $kelas->Guru->nama_guru . ', ' . $kelas->Guru->gelar);
                    $templateProcessor->setValue("nip_walkes", $kelas->Guru->nip ?? '-');
                    $templateProcessor->setValue("tanggal_ttd", $tanggal_ttd);

                    // Clone row sesuai jumlah siswa
                    $templateProcessor->cloneRow('no_urut', count($Siswa));

                    // Set value tiap row
                    foreach ($Siswa as $i => $s) {
                        $tanggal_lahir = Carbon::create($s->tanggal_lahir)->translatedFormat('d F Y');

                        $templateProcessor->setValue("no_urut#" . ($i + 1), $i + 1);
                        $templateProcessor->setValue("nama_siswa#" . ($i + 1), $s->nama_siswa);
                        $templateProcessor->setValue("jenis_kelamin#" . ($i + 1), $s->jenis_kelamin);
                        $templateProcessor->setValue("nisn#" . ($i + 1), $s->nisn);
                        $templateProcessor->setValue("nohp_siswa#" . ($i + 1), $s->nohp_siswa);
                        $templateProcessor->setValue("asal_sekolah#" . ($i + 1), $s->namasek_asal);
                        $templateProcessor->setValue("nik#" . ($i + 1), $s->nik);
                        $templateProcessor->setValue("ttl#" . ($i + 1), $s->tempat_lahir . ', ' . $tanggal_lahir);
                        $templateProcessor->setValue("alamat#" . ($i + 1), $s->alamat_siswa);
                        $templateProcessor->setValue("ayah_nama#" . ($i + 1), $s->ayah_nama);
                        $templateProcessor->setValue("ibu_nama#" . ($i + 1), $s->ibu_nama);
                    }

                    // Simpan file
                    $templateProcessor->saveAs($outputPath);

                    // Copy ke folder whatsapp jika mau kirim via Gateway
                    $result = CopyFileWa($filename, 'whatsapp/uploads');

                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $caption = "Data Siswa kelas $kelasNama berhasil dibuat.\nSilakan cek file: " . url('template/' . $filename) . "\n {$result['message']}";

                    // Kirim WA
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath);
                    break;

                // case 'D':
                //     runA();
                //     runB();
                //     runC();
                //     runF();
                //     break;

                default:
                    $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                    break;
            }
        }
    }
}
