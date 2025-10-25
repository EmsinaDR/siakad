<?php

use App\Models\Admin\Ekelas;
use App\Models\Admin\Identitas;
use App\Models\Whatsapp\WhatsApp;

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
                    // Export Absensi / Walkes/3
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
                case 'Jadwal Piket':
                    // Jadwal Piket / Walkes/3
                    $tapel = tapel();
                    $Kelas = Ekelas::where('kelas', $data[2])->where('tapel_id', $tapel->id)->first();
                    $tapelPelajaran = $tapel->tapel . "/" . $tapel->tapel + 1;
                    $caption =
                        "Berikut absensi untuk {$Kelas->kelas} \n" .
                        "Tahun Pelajaran {$tapelPelajaran} \n" .
                        " \n" .
                        "\n";

                    $filename = ExportAbsensiKelas($Kelas->id, $NoRequest);
                    $sessions = config('whatsappSession.IdWaUtama');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan('Export Absensi Kelas', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
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
                default:
                    $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                    break;
            }
        }
    }
}
