<?php

use App\Models\Admin\Ekelas;
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
                $filename = $namaFileJpg . '.' . $IsiPesan[3];
                $filePath = base_path('whatsapp/uploads/' . $filename);
                $caption = "File {$filename} telah selesai diproses";
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                // return $data;
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
                $filename = $filename . '.' . $IsiPesan[3];
                $filePath = base_path('whatsapp/uploads/' . $filename . '.pdf');
                $caption = "File {$filename} telah selesai diproses";
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
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
                $filename =  $filename . '.pdf';
                $filePath = base_path('whatsapp/uploads/' . $filename);
                $caption = "File {$filename} telah selesai diproses";
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
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
                $filename =  $filename . '.pdf';
                $filePath = base_path('whatsapp/uploads/' . $filename);
                $caption = "File {$filename} telah selesai diproses";
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
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
                $filename =  $filename . '.pdf';
                $filePath = base_path('whatsapp/uploads/' . $filename);
                $caption = "File {$filename} telah selesai diproses";
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                break;

            case 'Test Template':
                // Home Tidak Mampu / Surat / nis / keperluan

                // $kirimMedia = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, '6285329860005', $message);
                $fileExt = $IsiPesan[2] ?? Null; // keperluan
                $Identitas = Identitas::first();
                $data = [
                    'nomor_surat'    => '0209/15',
                    'nama_kepala' => $Identitas->namakepala,
                    'nama_sekolah' => $Identitas->namasek,
                    'nip_kepala' => $Identitas->nip_kepala ?? '-',
                    'pangkat_golongan' => $Identitas->pangkat_golongan ?? '-',
                    'kecamatan' => $Identitas->kecamatan ?? '-',
                    'bulan' => bulanRomawi(date('n')),
                    'tahun' => date('Y'),
                    'nama_siswa' => 'Dany Rosepta',
                    'tempat_lahir' => 'Brebes',
                    'tanggal_lahir' => '2 September 2025',
                    'tempat_tanggal_lahir' => 'Brebes, 2 September 2025',
                    'kelas' => 'VII B',
                    'alamat_siswa' => 'Jl. Makensi Desa Banjarharjo Kecamatan Banjarharjo Kabupaten Brebes. 52265.',
                ];
                $filenameDocx =  $Kode . ' - ' . $data['nama_siswa'] . '.docx';
                $filenamePdf =  $data['nama_siswa'] . '.pdf';
                $hasil = fill_docx_template(
                    public_path('template/template_surat_penerimaan_pindah.docx'),
                    $data,
                    base_path('whatsapp/uploads/' . $filenameDocx)
                );
                // fill_docx_template(string $templatePath, array $data, string $outputPath)
                // CopyFileWa('new_template_suat_penerimaan_pindah.docx', 'template');
                $docx = public_path('template/template_surat_penerimaan_pindah.docx');
                $filename = $filenameDocx;
                $FileKiriman  = base_path('whatsapp/uploads/' . $filename);
                $caption =
                    "File {$Kode} - {$filename} telah selesai diproses.\n" .
                    "Mohon periksa kembali file ini dan kesesuaian data yang di masukan.\n" .
                    "*Terima Kasih.*\n";
                sleep(10);
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_media("Generator {$Kode}", $caption), $FileKiriman); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                sleep(10);
                hapusFileWhatsApp($FileKiriman, $filename);
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $cek);
                break;
            case 'Surat Penerimaan Pindah Custom':
                // Surat Penerimaan Pindah / Surat / nomor_surat / tgl_surat / nama_siswa / tempat_tanggal_lahir / kelas / alamat_siswa
                $Identitas = Identitas::first();
                $hari = isset($IsiPesan[3]) && is_numeric($IsiPesan[3]) ? (int)$IsiPesan[3] : 0;
                $tanggal_surat = \Carbon\Carbon::now()->addDays($hari)->translatedFormat('d F Y');
                $nomor_surat = str_replace(':', '/', $IsiPesan[2]);
                $nama_siswa = $IsiPesan[4] ?? '-';
                $tempat_tanggal_lahir = $IsiPesan[5] ?? '-';
                $kelas = $IsiPesan[6] ?? '-';
                $alamat_siswa = $IsiPesan[7] ?? '-';
                $data = [
                    'nomor_surat'    => $nomor_surat,
                    'tanggal_surat'    => $tanggal_surat,
                    'nama_kepala' => $Identitas->namakepala,
                    'nama_sekolah' => $Identitas->namasek,
                    'nip_kepala' => $Identitas->nip_kepala ?? '-',
                    'pangkat_golongan' => $Identitas->pangkat_golongan ?? '-',
                    'kecamatan' => $Identitas->kecamatan ?? '-',
                    'bulan' => bulanRomawi(date('n')),
                    'tahun' => date('Y'),
                    'nama_siswa' => $nama_siswa,
                    'tempat_lahir' => 'Brebes',
                    'tanggal_lahir' => '2 September 2025',
                    'tempat_tanggal_lahir' => $tempat_tanggal_lahir,
                    'kelas' => $kelas,
                    'alamat_siswa' => $alamat_siswa,
                ];
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, json_encode($data));
                $filenameDocx =  $Kode . ' - ' . $data['nama_siswa'] . '.docx';
                $hasil = fill_docx_template(
                    public_path('template/' . $Identitas->namasingkat . '/template_surat_penerimaan_pindah.docx'),
                    $data,
                    base_path('whatsapp/uploads/' . $filenameDocx)
                );
                // fill_docx_template(string $templatePath, array $data, string $outputPath)
                // CopyFileWa('new_template_suat_penerimaan_pindah.docx', 'template');
                $docx = public_path('template/' . $Identitas->namasingkat . '/template_surat_penerimaan_pindah.docx');
                $filename = $filenameDocx;
                $FileKiriman  = base_path('whatsapp/uploads/' . $filename);
                $caption =
                    "File {$Kode} telah selesai diproses.\n" .
                    "Mohon periksa kembali file ini dan kesesuaian data yang di masukan.\n\n" .
                    "*No Surat :* \n{$nomor_surat}/MTs.IM/{$data['bulan']}/{$data['tahun']}\n" .
                    "*Tanggal Surat :* \n$tanggal_surat\n" .
                    "*Nama Siswa :* \n$nama_siswa\n" .
                    "*Tempat Tanggal Lahir :* \n$tempat_tanggal_lahir\n" .
                    "*Kelas :* \n$kelas\n" .
                    "*Alamaat Siswa :* \n$alamat_siswa\n" .
                    "*Keperluan :* \nPengajuan Pindah\n" .
                    "*Terima Kasih.*\n";
                sleep(10);
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_media("Generator {$Kode}", $caption), $FileKiriman);
                sleep(10);
                hapusFileWhatsApp($FileKiriman, $filename);
                break;
            case 'Surat SPPD Custom':
                $keyMessage = 'Case / bagian / nomor_surat / tgl_surat / kode_guru / jabatan_guru / tempat_tujuan / tanggal_berangkat / tanggal_pulang / kendaraan / tujuan_perjalanan';
                $dataPesan = combine_format_pesan($keyMessage, $message);

                //_____________________________________________________________________________________
                $keyMessage = 'Surat SPPD Custom / Surat / 225:SPPD / 2 / kode_guru / jabatan_guru / tempat_tujuan / tanggal_berangkat / tanggal_pulang / kendaraan / tujuan_perjalanan';
                // Contoh 'Case / bagian / nomor_surat / tgl_surat / AS:DR / jabatan_guru:jabatan_guru2 / tempat_tujuan / tanggal_berangkat / tanggal_pulang / kendaraan / tujuan_perjalanan';
                $data = combine_format_pesan($keyMessage, $message);
                $pesan = "Hasil Map Pesan \n";
                foreach ($data as $key => $value) {
                    $pesan .= $key . "=>" . $value . "\n";
                }
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesan);
                // return false;
                //_____________________________________________________________________________________
                $Identitas = Identitas::first();
                $hari = isset($IsiPesan[3]) && is_numeric($IsiPesan[3]) ? (int)$IsiPesan[3] : 0;
                $tanggal_surat = \Carbon\Carbon::now()->addDays($hari)->translatedFormat('d F Y');
                $nomor_surat = str_replace(':', '/', $IsiPesan[2]);
                $tanggal_berangkat = $IsiPesan[7] ?? '-';

                $hari_berangkat = isset($IsiPesan[7]) && is_numeric($IsiPesan[7]) ? (int)$IsiPesan[7] : 0;
                $tanggal_berangkat = \Carbon\Carbon::now()->addDays($hari_berangkat)->translatedFormat('d F Y');

                $hari_pulang = isset($IsiPesan[8]) && is_numeric($IsiPesan[8]) ? (int)$IsiPesan[8] : 0;
                $tanggal_pulang = \Carbon\Carbon::now()->addDays($hari_pulang)->translatedFormat('d F Y');

                $kendaraan = $IsiPesan[9] ?? '-';
                $tujuan_perjalanan = $IsiPesan[10] ?? '-';
                $namaGuruList = ['Dany Rosepta', 'Emira Nawal Zahbi']; // contoh array nama guru


                // Buat numbered list

                // Data Guru
                $kodeGuru = explode(':', $data['kode_guru']);
                $dataGuru = Detailguru::whereIn('kode_guru', $kodeGuru)->get();
                $namaGuru = '';
                foreach ($dataGuru as $index => $Guru) {
                    $namaGuru .= $index + 1 . ". " . $Guru->nama_guru . ', ' . $Guru->gelar . "\n";
                }

                // Jabatan
                $jabatan_guru = explode(':', $data['jabatan_guru']);
                $Listjabatan = '';
                foreach ($jabatan_guru as $index => $jabatan) {
                    $Listjabatan .= ($index + 1) . ". " . $jabatan . "\n";
                }
                $Listjabatan = rtrim($Listjabatan, "\r\n");

                $data['nama_guru'] = $namaGuru;
                $data['jabatan_guru'] = $Listjabatan;

                // $isipesan =
                $data = [
                    'nomor_surat'    => $nomor_surat . ' / ' . $Identitas->namasingkat,
                    'tanggal_surat'    => $tanggal_surat,
                    'nama_kepala' => $Identitas->namakepala,
                    'nama_sekolah' => $Identitas->namasek,
                    'nip_kepala' => $Identitas->nip_kepala ?? '-',
                    'pangkat_golongan' => $Identitas->pangkat_golongan ?? '-',
                    'kecamatan' => $Identitas->kecamatan ?? '-',
                    'bulan' => bulanRomawi(date('n')),
                    'tahun' => date('Y'),
                    // Data Guru
                    'nama_guru' => $data['nama_guru'] ?? '-',
                    'jabatan_guru' => $data['jabatan_guru'] ?? '-',
                    'tempat_tujuan' => $tujuan_perjalanan ?? '-',
                    'tanggal_berangkat' => $tanggal_berangkat ?? '-',
                    'tanggal_pulang' => $tanggal_pulang ?? '-',
                    'kendaraan' => $kendaraan ?? '-',
                    'tujuan_perjalanan' => $dataPesan['tujuan_perjalanan'] ?? '-',
                ];
                // $data =
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, json_encode($data));
                $filenameDocx =  $Kode . '.docx';
                // $filenamePdf =  $data['nama_siswa'] . '.pdf';
                $hasil = fill_docx_template(
                    public_path('template/' . $Identitas->namasingkat . '/template_sppd.docx'),
                    $data,
                    base_path('whatsapp/uploads/' . $filenameDocx)
                );
                // fill_docx_template(string $templatePath, array $data, string $outputPath)
                // CopyFileWa('new_template_suat_penerimaan_pindah.docx', 'template');
                // $docx = public_path('template/template_sppd.docx');
                $filename = $filenameDocx;
                $FileKiriman  = base_path('whatsapp/uploads/' . $filename);
                $caption =
                    "File {$Kode} telah selesai diproses.\n" .
                    "Mohon periksa kembali file ini dan kesesuaian data yang di masukan.\n\n" .
                    "*No Surat :* \n{$nomor_surat}/{$Identitas->namasingkat}/{$data['bulan']}/{$data['tahun']}\n" .
                    "*Tanggal Surat :* \n$tanggal_surat\n" .
                    "*Keperluan :* \n{$dataPesan['tujuan_perjalanan']}\n" .
                    "*Terima Kasih.*\n";
                sleep(10);
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_media("Generator {$Kode}", $caption), $FileKiriman);
                sleep(10);
                hapusFileWhatsApp($FileKiriman, $filename);
                break;
            case 'Home Visit Custom':
                $Identitas = Identitas::first();
                //_____________________________________________________________________________________
                //Dump Pesan Wa
                $keyMessage = trim('Case / Surat / nomor_surat / tanggal_surat / kode_guru / jabatan_guru / tanggal_kunjungan / jam_kunjungan / tempat_kunjungan / tujuan_kunjungan / nis / kirim_wa'); // Case / Guru / Kode_guru
                // Contoh = 'Home Visit Custom / Surat / 2025:SPPD / 2 / AS:DR / Guru BK:Wali Kelas / 2 / 08:30 / Rumah Siswa / 250001 / Ya#No'; // Case / Guru / Kode_guru
                $dataPesan = combine_format_pesan($keyMessage, $message);
                $data = [];
                foreach ($dataPesan as $key => $value) {
                    $data[$key] = $value;
                }
                // Data Guru
                $kodeGuru = explode(':', $data['kode_guru']);
                $dataGuru = Detailguru::whereIn('kode_guru', $kodeGuru)->get();
                $namaGuru = '';
                foreach ($dataGuru as $index => $Guru) {
                    $namaGuru .= $index + 1 . ". " . $Guru->nama_guru . "\n";
                }
                $namaGuru = rtrim($namaGuru, "\r\n");
                // Jabatan
                $jabatan_guru = explode(':', $data['jabatan_guru']);
                $Listjabatan = '';
                foreach ($jabatan_guru as $index => $jabatan) {
                    $Listjabatan .= ($index + 1) . ". " . $jabatan . "\n";
                }
                $Listjabatan = rtrim($Listjabatan, "\r\n");

                $datasiswa = Detailsiswa::where('nis', $data['nis'])->first()->toArray();
                $datasekolah = $Identitas->toArray();
                $data = array_merge($data, $datasekolah, $datasiswa);
                $tanggal_kunjungan = \Carbon\Carbon::now()->addDays((int)$data['tanggal_kunjungan'])->translatedformat('d F Y');
                $data['tanggal_kunjungan'] = $tanggal_kunjungan;
                $tanggal_surat = \Carbon\Carbon::now()->addDays((int)$data['tanggal_surat'])->translatedformat('d F Y');
                $data['tanggal_surat'] = $tanggal_surat;
                $data['kelas'] = Ekelas::find($datasiswa['kelas_id'])->kelas ?? '-';
                $data['nama_guru'] = rtrim($namaGuru, '\n');
                $data['jabatan_guru'] = rtrim($Listjabatan, '\n');
                $data['bulan'] = bulanRomawi(date('n'));
                $data['tahun'] = date('Y');

                $filename = 'template_home_visit.docx'; // file name untuk dikirim atau hasil created
                $filetemplate = 'template_home_visit.docx';
                $hasil = fill_docx_template(
                    public_path('template/' . $Identitas->namasingkat . '/' . $filetemplate),
                    $data,
                    base_path('whatsapp/uploads/' . $filename)
                );
                if ($data['kirim_wa'] === 'ya') {
                }
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, json_encode($data));
                //CopyFileWa(filename, 'template'); // template : folder di public jika diperlukan
                $FileKiriman  = base_path('whatsapp/uploads/' . $filename);
                $caption =
                    "Berikut File Surat Home Visit :\n" .
                    "No Surat :\n {$data['nomor_surat']} / {$Identitas->namasingkat} / {$data['bulan']} / {$data['tahun']}\n" .
                    "Atas Nama Siswa :\n {$datasiswa['nama_siswa']}\n" .
                    "Guru / Petugas :\n{$namaGuru}\n" .
                    "Tanggal Kunjungan :\n {$tanggal_kunjungan}\n" .
                    "Jam Kunjungan :\n {$data['jam_kunjungan']}\n\n" .
                    "*Terima Kasih.*\n";
                sleep(10);
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_media("Generator {$Kode}", $caption), $FileKiriman);
                sleep(10);
                // Pemeritahuan awal ke ortu melalui whtsapp
                Whatsaap_surat_siswa($dataPesan);
                sleep(10);
                hapusFileWhatsApp($FileKiriman, $filename);
                return false;
                //_____________________________________________________________________________________


                // Untuk pengecekan bisa gunakan : dump::pesan-wa-dump-pesan-whatsapp-laravel



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
            case 'Suket PIP':
                //Suket PIP / Guru / Kode Guru / array_siswa / tahap
                //_____________________________________________________________________________________
                // Data Sekolah
                $Identitas = Identitas::first()->toArray();
                //Dump Pesan Wa
                $keyMessage = 'Case / Surat / nomor_surat / tanggal_surat / Kode Guru / array_siswa / tahap';
                $dataPesan = combine_format_pesan($keyMessage, $message);
                $data = [];
                foreach ($dataPesan as $key => $value) {
                    $data[$key] = $value;
                }
                $data['nomor_surat'] = str_replace(':', '/', $data['nomor_surat']) . '/' . $Identitas['namasingkat'] . '/' . bulanRomawi(date('n')) . '/' . date('Y');
                // Data Guru
                // $Gurus = Detailguru::whereIn('kode_guru', $data['kode_guru'])->first();
                // $dataSurat =
                $data['tanggal_surat'] = Carbon::create(now($data['tanggal_surat']))->translatedformat('d F Y');
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, json_encode($dataAll));
                // return false;
                //_____________________________________________________________________________________

                // DataSiswa
                $arrayNis = explode(":", $data['array_siswa']);
                $Siswa = Detailsiswa::whereIn('nis', $arrayNis)->get();

                // mapping data sesuai placeholder di template
                $data['siswa'] = $Siswa->map(function ($row, $i) {
                    // $kelas = Ekelas::where('kelas_id', $row->kelas_id)->first();
                    return [
                        'no'   => $i + 1,
                        'nis'   => $row->nis,
                        'nama_siswa'  => $row->nama_siswa,
                        'tingkat'  => $row->tingkat_id,
                        'nomor_kip'  => $row->kartu_bantuan_1 ?? '-',
                    ];
                })->toArray();
                $dataAll = array_merge($data, $Identitas, [
                    'siswa' => $data['siswa'],
                ]);
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, json_encode($data['siswa']));
                // return false;
                $filename = 'template_pip.docx'; // file name untuk dikirim atau hasil created
                $filetemplate = 'template_pip.docx';
                $hasil = fill_docx_template_complex(
                    public_path('template/' . $Identitas['namasingkat'] . '/' . $filetemplate),
                    $dataAll,
                    base_path('whatsapp/uploads/' . $filename)
                );
                sleep(10);
                $FileKiriman  = base_path('whatsapp/uploads/' . $filename);
                $caption =
                    // "Berikut File Surat Home Visit :\n" .
                    // "No Surat :\n {$data['nomor_surat']} / {$Identitas['namasingkat']} / {$data['bulan']} / {$data['tahun']}\n" .
                    // "Atas Nama Siswa :\n {xxxxxxx}\n" .
                    // "Guru / Petugas :\n{xxxxxxx}\n" .
                    // "Tanggal Kunjungan :\n {xxxxxxx}\n" .
                    // "Jam Kunjungan :\n {xxxxxxxxxxx}\n\n" .
                    "*Terima Kasih.*\n";
                sleep(10);
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_media("Generator {$Kode}", $caption), $FileKiriman);

                $isiPesan =
                    "isikiriman\n" .
                    " \n ";
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Surat Keterangan Lulus':
                $keyMessage = 'Case / Guru / kode_guru'; // Case / Guru / Kode_guru
                $dataPesan = combine_format_pesan($keyMessage, $message);
                // Untuk pengecekan bisa gunakan : dump::pesan-wa-dump-pesan-whatsapp-laravel



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
            case 'Surat Keterangan Keterangan':
                $keyMessage = 'Case / Guru / kode_guru'; // Case / Guru / Kode_guru
                $dataPesan = combine_format_pesan($keyMessage, $message);
                // Untuk pengecekan bisa gunakan : dump::pesan-wa-dump-pesan-whatsapp-laravel



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
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
