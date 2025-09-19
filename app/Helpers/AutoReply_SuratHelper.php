<?php

use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use Carbon\CarbonPeriod;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\Log;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 AutoReply_SuratHelper : WhatsAppController
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - Proses Code AutoReply di WhatsAppController agar lebih ringkas
        | - Autoreply kode Surat
        |
        | Tujuan :
        | - xxxxxxxxxxx
        |
        | Penggunaan :
        | - xxxxxxxxxxx
        |
    */

// Proses Coding
if (!function_exists('SuratKode')) {
    function SuratKode($NoRequest, $message)
    {

        $IsiPesan = explode('/', $message);
        $Kode = $IsiPesan[0];
        $Tujuan = $IsiPesan[1]; //Siswa
        $sessions = config('whatsappSession.IdWaUtama');

        // $Siswa = Detailsiswa::with('KelasOne')->where('nis', $nis)->first();
        switch ($Kode) {
            case 'Surat Aktif': //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
                //  Surat Aktif/Surat/nis/jpg/keperluan
                $IsiPesan = explode('/', $message);
                $nis = $IsiPesan[2]; //nis
                // Pembuatan Surat
                // 📄 Data untuk PDF
                $DataSIswa = DataSIswa($nis);
                $dataIdentitas = DataIdentitas();
                $dataSurat = [
                    'keperluan'      => $IsiPesan[4],
                    'tanggal_surat'  => Carbon::create(now())->translatedformat('d F Y'),
                    'lokasi_surat'   => 'Kota Edukasi',
                    'logo'           => 'img/logo.png',
                ];
                $data = array_merge($dataSurat, $dataIdentitas, $DataSIswa);
                // 🖨️ Generate PDF
                $view = 'role.program.surat.surat-aktif-siswa';
                $filename = 'Surat-Aktif-' . $nis;
                DomExport($filename, $data, $view, $folder = null);
                sleep(10);

                $namaFileJpg = 'Surat-Aktif-' . $nis;
                $filer = WhatsApp::pdfToImageWa($namaFileJpg); // Pdf to Image Converter
                $pesanKiriman = PesanUmumSuratSiswa($nis, $Kode); // Isi Pesan
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                $data = [
                    'nama_file' => $namaFileJpg . '.' . $IsiPesan[3],
                    'pesan' => $pesanKiriman,

                ];
                return $data;
                break;

            case 'Surat Pindah': //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
                // Surat Pindah/Surat/NIS/sekolah tujuan/alamat sekolah tujuan/alasan pindah

                $IsiPesan = explode('/', $message);
                $nis = $IsiPesan[2]; //nis
                $Part3 = $IsiPesan[3] ?? Null; // Sekolah Tujuan
                $Part4 = $IsiPesan[4] ?? Null; // Alamat Sekolah Tujuan
                $Part5 = $IsiPesan[5] ?? Null; // alasan pindah
                $Identitas = Identitas::first();
                $tanggal_surat = Carbon::create(now())->translatedformat('d F Y');
                $dataSurat = [
                    'sekolah_tujuan' => $Part3 ?? '-',
                    'alamat_sekolah_tujuan' => $Part4 ?? '-',
                    'alasan_pindah' => $Part5 ?? '-',
                    'nomor_surat' => '-',
                    'tanggal_surat'  => $tanggal_surat,
                ];
                $DataSIswa = DataSIswa($nis);
                $dataIdentitas = DataIdentitas();
                // $dataGuru = DataGuru($nis);
                $data = array_merge($dataSurat, $dataIdentitas, $DataSIswa);
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, json_encode($DataSIswa));
                $view = 'role.program.surat.siswa.surat-pindah-sekolah';
                $filename = $Kode . ' - ' . $nis;
                DomExport($filename, $data, $view, $folder = null);
                $pesanKiriman = 'Tunggu sejenak proses pembuatan dan pengiriman Surat ' . $filename;
                $data = [
                    'nama_file' => $filename . '.pdf',
                    'pesan' => $pesanKiriman,

                ];
                return $data;
                break;
            case 'Surat Home Visit': // Surat Home Visit/Surat/KodeGuru/Jabatan/nis/keperluan/+Hari/Waktu

                $Part3 = $IsiPesan[3] ?? Null; // Jabatan
                $nis = $IsiPesan[4] ?? Null; // NIS
                $Part5 = $IsiPesan[5] ?? Null; // Keperluan
                $Part6 = $IsiPesan[6] ?? Null; // Tanggal Kunjungan
                $Part7 = $IsiPesan[7] ?? Null; // Keperluan
                $Siswa = Detailsiswa::with('KelasOne')->where('nis', $nis)->first();
                $Identitas = Identitas::first();
                $tanggal_surat = Carbon::create(now())->translatedformat('d F Y');
                $Hari = Carbon::now()->addDays((int)$Part6)->translatedformat('l, d F Y');
                $DataSIswa = DataSIswa($nis);
                $dataSurat = [
                    'alasan_homevisit' => $Part5 ?? '-',
                    'hari_tanggal_kunjungan' => $Hari ?? '-',
                    'waktu_kunjungan' => $Part7 ?? '-',
                    'nomor_surat' => '-',
                    'tanggal_surat'  => $tanggal_surat,
                    'jabatan' => $Part3 ?? '-',
                ];
                $dataIdentitas = DataIdentitas();
                $dataGuru = DataGuru($nis);
                $data = array_merge($dataSurat, $dataIdentitas, $dataGuru, $DataSIswa);
                Log::info("Request received: Number - $NoRequest, Nis - $nis dan Kode = $Kode");
                $view = 'role.program.surat.siswa.home-visit';
                $filename = $Kode . ' - '  . $nis;
                DomExport($filename, $data, $view, $folder = null);
                $pesanKiriman = PesanUmumSuratSiswa($Siswa->nis, $Kode); // Isi Pesan
                $pesanKiriman = 'Tunggu sejenak proses pembuatan dan pengiriman Surat ' . $filename;
                $data = [
                    'nama_file' => $filename . '.pdf',
                    'pesan' => $pesanKiriman,

                ];
                return $data;
                break;

            case 'Surat Panggilan': // Surat Panggilan/Surat/kode guru waka/kode wali kelas/NIS/keperluan/+Hari/Waktu/

                $waka = $IsiPesan[2] ?? Null; // Waka
                $guru = $IsiPesan[3] ?? Null; // Wali Kelas
                $nis = $IsiPesan[4] ?? Null; // NIS
                $Part5 = $IsiPesan[5] ?? Null; // keperluan
                $Part6 = $IsiPesan[6] ?? Null; // +Hari
                $Part7 = $IsiPesan[7] ?? Null; // Waktu
                $noSurat = $IsiPesan[8] ?? Null; // Waktu
                // $Siswa = Detailsiswa::with('KelasOne')->where('nis', $Part3)->first(); //NIS
                // $Identitas = Identitas::first();
                $tanggal_surat = Carbon::create(now())->translatedformat('d F Y');
                $Hari = Carbon::now()->addDays((int)$Part5)->translatedformat('l, d F Y'); //Hari
                $DataSIswa = DataSIswa($nis); //NIS
                $dataSurat = [
                    'hari_tanggal_kunjungan' => $Hari ?? '-',
                    'keperluan'  => $Part5 ?? '-',
                    'waktu_kunjungan' => $Part7 ?? '-',
                    'tanggal_surat'  => $tanggal_surat,
                    'nomor_surat'  => $noSurat,
                ];
                $dataIdentitas = DataIdentitas();
                $Waka = DataWaka($waka);
                $Walkes = DataGuru($guru);
                $data = array_merge(
                    $dataSurat,
                    $dataIdentitas,
                    $Waka,
                    $Walkes,
                    $DataSIswa
                );
                Log::info("Request received: Number - $NoRequest, Nis - $nis dan Kode = $Kode");
                $view = 'role.program.surat.siswa.surat-panggilan';
                $filename = $Kode . ' - '  . $nis;
                DomExport($filename, $data, $view, $folder = null);
                $pesanKiriman = PesanUmumSuratSiswa($nis, $Kode); // Isi Pesan
                $pesanKiriman = 'Tunggu sejenak proses pembuatan dan pengiriman Surat ' . $filename;
                $data = [
                    'nama_file' => $filename . '.pdf',
                    'pesan' => $pesanKiriman,

                ];
                return $data;
                break;

            case 'Surat Tidak Mampu':
                // Home Tidak Mampu / Surat / nis / keperluan
                $nis = $IsiPesan[2]; //nis
                $Part3 = $IsiPesan[3] ?? Null; // keperluan
                $Part4 = $IsiPesan[4] ?? Null; //
                $Part5 = $IsiPesan[5] ?? Null; //
                $Part6 = $IsiPesan[6] ?? 1; //
                $Part7 = $IsiPesan[7] ?? Null; //
                $Siswa = Detailsiswa::with('KelasOne')->where('nis', $Part4)->first();
                $Identitas = Identitas::first();
                $tanggal_surat = Carbon::create(now())->translatedformat('d F Y');
                $Hari = Carbon::now()->addDays((int)$Part6)->translatedformat('l, d F Y');
                $DataSIswa = DataSIswa($nis);
                $dataSurat = [
                    'keperluan' => $Part3 ?? '-',
                    'nomor_surat' => '-',
                    'tanggal_surat'  => $tanggal_surat,
                ];
                $dataIdentitas = DataIdentitas();
                // $dataGuru = DataGuru($nis);
                $data = array_merge($dataSurat, $dataIdentitas, $DataSIswa);
                $view = 'role.program.surat.siswa.surat-tidak-mampu';
                $filename = 'Surat ' . $Kode . ' - '  . $nis;
                DomExport($filename, $data, $view, $folder = null);
                // $sessions = config('whatsappSession.IdWaUtama');
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  json_encode($data));
                $pesanKiriman = 'Tunggu sejenak proses pembuatan dan pengiriman Surat ' . $filename;
                $data = [
                    'nama_file' => $filename . '.pdf',
                    'pesan' => $pesanKiriman,

                ];
                return $data;
                break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
