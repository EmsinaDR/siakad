<?php

use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use Carbon\CarbonPeriod;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\Log;
use App\Models\User\Guru\Detailguru;
use App\Models\Whatsapp\WhatsappLog;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Absensi\DataIjinDigital;

/*
        |--------------------------------------------------------------------------
        | 📌 AutoReply_SiswaHelper : WhatsAppController
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - Proses Code AutoReply di WhatsAppController agar lebih ringkas
        | - Autoreply kode Siswa
        |
        | Tujuan :
        | - xxxxxxxxxxx
        |
        | Penggunaan :
        | - xxxxxxxxxxx
        |
    */

// Proses Coding
if (!function_exists('cek_data_ortu')) {
    function cek_data_ortu($NoRequest, $Nis)
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
            if ($NoRequest === config('whatsappSession.DevNomorTujuan')) {
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
if (!function_exists('Auto_reply_SiswaKode')) {
    function Auto_reply_SiswaKode($Siswa, $NoRequest, $message)
    {

        $IsiPesan = explode('/', $message);
        $Kode = $IsiPesan[0];
        $Tujuan = $IsiPesan[1]; //Siswa
        $nis = $IsiPesan[2]; //nis

        $sessions = config('whatsappSession.IdWaUtama');
        $Identitas = Identitas::first();
        $Kelas = $Siswa->Detailsiswatokelas->kelas;
        $Nama = $Siswa->nama_siswa;
        $NamaAyah = $Siswa->ayah_nama;
        $IdSiswa = $Siswa->id;
        $Nis = $Siswa->nis;
        Log::info("Request received: Number - $NoRequest, Nis - $Nis dan Kode = $Kode");
        WhatsappLog::LogWhatsapp($NoRequest, $message);

        if (!cek_data_ortu($NoRequest, $Nis)) {
            return;
        };
        // TODO: Implement your helper logic here
        switch (ucfirst($Kode)) {
            case 'Data Siswa':
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  PesanDataSiswa($Siswa->id));
                break;
            case 'Pembayaran':
                // Pembayaran/Siswa/25001/Rekap
                // FiturPaket(getIdentitas()->paket, $NoRequest);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  PesanPembayaran($Siswa->id));
                break;
            case 'Tabungan':
                // Tabungan/Siswa/25001/Rekap
                FiturPaket(getIdentitas()->paket, $NoRequest);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, tabungan_siswa($Siswa->id));
                break;
            case 'Data BK':
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  PesanPembayaran($Siswa->id));
                break;
            case 'Jadwal Ekstra':
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, PesanEkstra($Siswa->id));
                break;
            case 'Absensi':
                // Absensi / Siswa / Nis / 1-12
                $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                $bulan = $pesan[3] ?? null;
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, PesanAbsensi($Siswa->id));
                // if (!$bulan) {
                //     $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, PesanAbsensi($Siswa->id));
                // } else {
                //     $bulan = $pesan[3];
                //     $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, PesanAbsensiBulananOrtu($Siswa->id, $bulan));
                // }
                break;
            case 'Absensi Bulanan':
                // Absensi / Siswa / Nis / 1-9
                $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                $bulan = $pesan[3];
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, PesanAbsensiBulananOrtu($Siswa->id, $bulan));
                break;
            case 'Register':
                // Register/Siswa/nis/nosiswa:noayah:noibu
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, registerNoHp($Siswa, $message, $NoRequest));
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $Siswa->nama_siswa);
                break;
            case 'Sample':
                // Register/Siswa/nis/nosiswa:noayah:noibu
                $DataNis = ['250001', '250002', '250003'];
                foreach ($DataNis as $pesannis) {
                    $pesanKiriman =
                        "Register/Siswa/{$pesannis}/nohp\n";
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                }
                break;
            case 'Ijin Siswa':
                // Ijin Siswa / Siswa / 2025001 / Ijin / Keterangan
                DataIjinDigital::createByWa($NoRequest, $message);
                break;

            // ✅ Tidak perlu `break` karena sudah `return`
            case 'Kelulusan':
                $pesanKiriman =
                    "==================================\n" .
                    "📌 *Data $Kode Siswa*\n" .
                    "==================================\n\n" .
                    "📝 Nama\t\t\t: $Nama\n" .
                    "🏫 Kelas\t\t\t: $Kelas\n" .
                    "📅 Tanggal\t\t: tanggal \n" .
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirim oleh:\n" .
                    "\t\t*Boot Asisten Pelayanan {$Identitas->namasek}*\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                // return response()->json([
                //     'status' => 'success',
                //     'reply' => "Pesan telah diteruskan"
                // ]);
                break;
            case 'Gambar': //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
                $file = asset("storage/Foto.JPG");
                $pesanKiriman =
                    "==================================\n" .
                    "📌 *Data $Kode Siswa*\n" .
                    "==================================\n\n" .
                    "📝 Nama\t\t\t: $Nama\n" .
                    "🏫 Kelas\t\t\t: $Kelas\n" .
                    "📅 Tanggal\t\t: tanggal\n" .
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirim oleh:\n" .
                    "\t\t*Boot Asisten Pelayanan {$Identitas->namasek}*\n";
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                return response()->json([
                    'status' => 'success',
                    'reply' => $pesanKiriman,
                    'file' => 'Uploads/tabungan.pdf'
                ]);

                // case 'Surat Aktif': //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
                //     $newpesan = explode('/', $message); // Format: "/aktif/beasiswa"
                //     // Pembuatan Surat
                //     // 📄 Data untuk PDF
                //     $DataSIswa = DataSIswa($nis);

                //     $dataIdentitas = DataIdentitas();
                //     $dataSurat = [
                //         'keperluan'      => $newpesan[4],
                //         'tanggal_surat'  => Carbon::create(now())->translatedformat('d F Y'),
                //         'lokasi_surat'   => 'Kota Edukasi',
                //         'logo'   => 'img/logodev.jpg',
                //     ];
                //     $data = array_merge($dataSurat, $dataIdentitas, $DataSIswa);
                //     // 🖨️ Generate PDF
                //     $view = 'role.program.surat.surat-aktif-siswa';
                //     $filename = 'Surat-Aktif-' . $Siswa->nis;
                //     $namaFileJpg = 'Surat-Aktif-' . $Siswa->nis;
                //     DomExport($filename, $data, $view, $folder = null);
                //     sleep(10);
                //     $filer = WhatsApp::pdfToImageWa($namaFileJpg);
                //     // Chat Blasan dan Pengiriman File
                //     // 🟢 Buat pesan kiriman WA
                //     $nama = $DataSIswa['nama_siswa'];
                //     $kelas = $DataSIswa['kelas'];
                //     $pesanKiriman =
                //         "==================================\n" .
                //         "📌 *Data Siswa ($Kode)*\n" .
                //         // "==================================\n\n" .
                //         "📝 Nama\t\t\t: $nama\n" .
                //         "🏫 Kelas\t\t\t: $kelas\n" .
                //         "📅 Tanggal\t\t: " . Carbon::now()->translatedFormat('d F Y') . "\n\n" .
                //         str_repeat("─", 25) . "\n" .
                //         "📎 File Surat Aktif: sedang proses pembuatan\n" .
                //         "✍️ Dikirim oleh:\n" .
                //         "\t\t*Bot Asisten - {$Identitas->namasek}* \n";

                //     //
                //     return response()->json([
                //         'status' => 'success',
                //         'reply' => $pesanKiriman,
                //         'file' => 'Uploads/' . $namaFileJpg . '.' . $newpesan[3], //Jika ingin kirim via Whatsapp harus simpan di folder upload whatsapp
                //     ]);

            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
