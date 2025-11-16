<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Admin\Ekelas;
use App\Models\Absensi\Eabsen;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 AutoReply_GuruHelper :
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

if (!function_exists('validateWhatsappAccess')) {
    /**
     * Validasi apakah nomor WA punya akses
     *
     * @param string $NoRequest   Nomor WA yang request
     * @param string $DevNomor    Nomor developer (bypass)
     * @param object|null $Guru   Data guru (punya no_hp)
     * @param mixed $sessions     Session WA untuk kirim pesan
     * @return bool|\Illuminate\Http\JsonResponse
     */
    // function validateWhatsappAccess($NoRequest, $Guru)
    // {
    //     $sessions = config('whatsappSession.IdWaUtama');
    //     $DevNomor = config('whatsappSession.DevNomorTujuan');
    //     $SekolahNoTujuan = config('whatsappSession.SekolahNoTujuan');
    //     if ($NoRequest !== $DevNomor) { // Lolosakan Dev
    //         if (!$Guru || $NoRequest !== $Guru->no_hp) {
    //             // Kirim pesan kalau tidak diijinkan
    //             \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan("❌ Informasi", "Maaf anda tidak berhak mengakses data ini!!!\n*NO HP tidak terdaftar*"));
    //             $PesanKirim =
    //                 "Di informasikan bahwa ada akses tidak sah dari :\n" .
    //                 "No HP : {$NoRequest}\n" .
    //                 "Berusaha mencoba akses data siswa :\n" .
    //                 "Nama : {$Guru->nama_guru}\n" .
    //                 "\n";
    //             $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $SekolahNoTujuan, format_pesan('⚠️ Informasi Warning ⚠️', $PesanKirim));
    //             return false;
    //         }
    //     }

    //     return true;
    // }
}

if (!function_exists('Auto_reply_Data_Guru')) {
    function Auto_reply_Data_Guru($Kode, $NoRequest, $message, $sessions)
    {

        $data = explode('/', $message);
        $Guru = Detailguru::where('kode_guru', $data[2])->first();
        $DevNomor = config('whatsappSession.DevNomorTujuan');
        if (!validateWhatsappAccessGuruUmum($NoRequest, $Guru)) {
            return; // stop eksekusi
        }
        // lanjut proses lainnya, karena guru valid atau dev
        switch (ucfirst($Kode)) {
            // case 'Data Guru': // Data Guru/Guru/Kode_Guru
            // // Ambil data pesan & kode guru
            // $pesan = DataKodeGuru($Guru->id);
            // $Carifilename = $pesan['kode_guru'] . '.png';

            // // Proses copy foto guru
            // $copyFile = CopyFileWa($Carifilename, 'img/guru/foto/');


            // // Validasi hasil copy (apakah file berhasil dicopy atau ada fallback)
            // if (!isset($copyFile['status']) || $copyFile['status'] === 'error' || !file_exists(public_path('img/guru/foto/' . $Carifilename))) {
            //     // Fallback otomatis jika file guru tidak ditemukan
            //     $filename = 'blanko-foto.png';
            //     $sourcePath = public_path('img/default/' . $filename);
            // } else {
            //     $filename = $copyFile['file'];
            //     $sourcePath = public_path('img/guru/foto/' . $filename);
            // }

            // // Pastikan fallback juga ada
            // if (!file_exists($sourcePath)) {
            //     Log::warning("Foto guru tidak ditemukan, fallback gagal: {$sourcePath}");
            //     $sourcePath = public_path('img/default/blanko-foto.png');
            // }

            // // Pindahkan file ke folder WhatsApp sementara (karena WhatsApp API hanya bisa kirim dari folder whatsapp)
            // $targetPath = base_path('whatsapp/uploads/' . $filename);
            // if (!file_exists(dirname($targetPath))) {
            //     mkdir(dirname($targetPath), 0777, true);
            // }

            // copy($sourcePath, $targetPath);

            // // Kirim media via WhatsApp
            // $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $pesan['pesanKiriman'], $targetPath);

            case 'Data Guru': // Data Guru/Guru/Kode_Guru
                // Ambil data pesan & kode guru
                $pesan = DataKodeGuru($Guru->id);
                $Carifilename = $pesan['kode_guru'] . '.png';

                // Proses copy foto guru

                $srcsumber = public_path('img/guru/foto/' . $Carifilename);

                // Cek apakah file ada
                if (file_exists($srcsumber)) {
                    // 📎 Kirim media kalau file tersedia
                    CopyFileWa($Carifilename, 'img/guru/foto');
                    $filePath = base_path('whatsapp/uploads/' . $Carifilename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $pesan['pesanKiriman'], $filePath);

                    Log::info("Media dikirim ke WA: {$Carifilename}");
                } else {
                    // ⚠️ Kirim pesan fallback kalau file gak ditemukan
                    $namaFile = 'blanko-foto.png';
                    CopyFileWa($namaFile, 'img/default');
                    $filePath = base_path('whatsapp/uploads/' . $namaFile);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $pesan['pesanKiriman'], $filePath);
                }
                break;
            case 'Ijin Guru': // Ijin Guru/Guru/Kode_Guru/sakti#ijin/keterangan/tugas
                $Identitas = getIdentitas();
                $message = preg_replace("/\r\n|\n|\r/", "/", $message);
                $pesan = explode('/', $message);
                $kodeGuruPiket = ['AS', 'JM'];
                $GuruIjin = Detailguru::where('kode_guru', $pesan[2])->first();
                $sessions = config('whatsappSession.IdWaUtama');
                if (!config('whatsappSession.WhatsappDev')) {
                    $GuruPiket = Detailguru::whereIn('kode_guru', $kodeGuruPiket)->pluck('no_hp');
                    $NoKepala = config('whatsappSession.NoKepala');
                } else {
                    $GuruPiket = ['6285329860005', '6282324399566'];
                    $NoKepala = config('whatsappSession.DevNomorTujuan');
                }
                $pesanKiriman =
                    "Berikut rincian data ijin Bapak / Ibu yang akan disampaikan pada guru piket dan pihak sekolah :\n" .
                    "Nama : {$GuruIjin->nama_guru}, {$GuruIjin->gelar}\n" .
                    "Data : {$pesan[3]}\n" .
                    "Keterangan : {$pesan[4]}\n" .
                    "Tugas : \n{$pesan[5]}\n\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  format_pesan('Data Ijin Guru', $pesanKiriman));
                // Pesan ke Guru Piket
                foreach ($GuruPiket as $NoGuruPiket):
                    $pesanKiriman =
                        "Nama : {$GuruIjin->nama_guru}, {$GuruIjin->gelar}\n" .
                        "Data : {$pesan[3]}\n" .
                        "Keterangan : {$pesan[4]}\n" .
                        "Tugas : \n{$pesan[5]}\n\n" .
                        json_encode($GuruPiket);
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoGuruPiket,  format_pesan('Data Tugas Guru Ijin untuk Guru Piket', $pesanKiriman));
                endforeach;
                // Pesan Ke Kamad
                $pesanKiriman =
                    "Bapak / Ibu Kepala {$Identitas->namasek} berikut informasi ijin yang masuk ke system :\n" .
                    "Nama : {$GuruIjin->nama_guru}, {$GuruIjin->gelar}\n" .
                    "Data : {$pesan[3]}\n" .
                    "Keterangan : {$pesan[4]}\n" .
                    "Tugas : \n{$pesan[5]}\n\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoKepala,  format_pesan('Data Ijin Guru Untuk Kepala', $pesanKiriman));
                // Input Ke Absensi Guru
                break;
            case 'Jumlah Siswa': // Jumlah Siswa/Guru/Kode_Guru
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  JumlahSiswa());
                break;
            case 'Data Sekolah':
                // Data Sekolah/Guru/Kode_Guru
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, DataSekolah($Guru->kode_guru));
                break;
            case 'Laporan Guru':
                // Laporan Guru/Guru/Kode_Guru/Mapel/Jam ke/arraynis/Keterangan
                // Laporan Guru/Guru/DR/Matematika/1-2/250001:250002/Keterangan
                /*
                   1 Laporan Guru = $message[0]  -> xxxxxxxxxxxx
                   2 Guru = $message[1]  -> xxxxxxxxxxxx
                   3 Kode Guru = $message[2]  -> xxxxxxxxxxxx
                   4 Mapel = $message[3]  -> Matematika
                   5 Jam ke = $message[4]  -> 1-2
                   6 arraynis = $message[5]  -> 250001:250002
                   7 Keterangan = $message[6]  -> Keterangan
                   8 xxxxxxx = $message[7]  -> xxxxxxxxxxxx
                   9 xxxxxxx = $message[8]  -> xxxxxxxxxxxx
                   10 xxxxxxx = $message[9]  -> xxxxxxxxxxxx
                */
                $pesan = explode('/', $message);
                $Mapel = $pesan[3];
                $jamKe = $pesan[4];
                $ArrayNis = explode(':', $pesan[5]); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                $Siswas = Detailsiswa::with('KelasOne')->whereIn('nis', $ArrayNis)->get();
                $siswaBolos = '';
                $siswaBolos = $Siswas->pluck('nama_siswa')
                    ->map(fn($nama) => "\n- {$nama}")
                    ->implode("");
                foreach ($Siswas as $siswa) {
                    $dataWa =  getWhatsappConfig($siswa);
                    $hari = Carbon::create(now())->translatedformat('l, d F Y');
                    if (isset($pesan[6])) {
                        $keterangan = $pesan[6];
                    } else {
                        $keterangan = "*Tanpa keterangan / Bolos*";
                    }
                    $isi =
                        "Diberitahukan kepada orang tua wali dari *Ananda {$siswa->nama_siswa}*, pada hari ini {$hari}, dinyatakan *Ananda {$siswa->nama_siswa}* tidak mengikuti pelajaran *{$Mapel}*, karena tidak ada didalam kelas.\n" .
                        "Keterangan :\n{$keterangan}\n\n" .
                        "Atas perhatiannya kami sampaikan terima kasih" .
                        "\n";
                    $PesanKirim = format_pesan('Informasi Kehadiran Pelajaran', $isi);
                    // Ke Orang Tua
                    if (!config('whatsappSession.WhatsappDev')) {
                        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($dataWa['sessions'], $dataWa['nomor'], $PesanKirim);
                    } else {
                        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($dataWa['sessions'], config('whatsappSession.DevNomorTujuan'), $PesanKirim);
                    }
                }
                // Ke Wali Kelas
                // $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.WhatsappDev') ? config('whatsappSession.DevNomorTujuan')  : $siswa->KelasOne->Guru->no_hp;
                $sapaan = $siswa->KelasOne->Guru->jenis_kelamin === 'Perempuan' ? 'Ibu' : 'Bapak';
                $PesanKirimWalkes =
                    "Diberitahunkan kepada *{$sapaan} {$siswa->KelasOne->Guru->nama_guru},{$siswa->KelasOne->Guru->gelar}*, bahwasanya siswa kelas {$siswa->KelasOne->kelas} tidak mengikuti pelajaran tanpa keterangan / bolos.\n" .
                    "Berikut ini data yang siswanya :" .
                    "{$siswaBolos}\n" .
                    "Keterangan :\n{$keterangan}\n\n" .
                    "Mohon segera ditindak lanjuti!!!\n" .
                    "Atas perhatiannya kami sampaikan terima kasih.\n" .
                    "";
                $PesanKirim = format_pesan('Informasi Kehadiran Pelajaran', $PesanKirimWalkes);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($dataWa['sessions'], $NoTujuan, $PesanKirim);
                break;
            case 'Absensi SG':
                $tapel = tapel();
                /*
                    Abseni SG / Guru / Kode Guru / Kelas / Masuk # Pulang / absen / pilihan / arraynis / Keterangan ( Sebut Kegiatan )
                    Abseni SG / Guru / AN / VII A / masuk / alfa # sakit # ijin # hadir / nis # All / 250001:250002 / Rapat Guru
                */
                /*
                       1 Abseni SG = $message[0]  ->  Abseni SG
                       2 Guru = $message[1]  -> Guru
                       3 Kode Guru = $message[2]  -> AN
                       4 Kelas = $message[3]  -> VII A
                       5  Masuk # Pulang = $message[4]  -> masuk
                       6 absen = $message[5]  -> hadir # alfa # sakit # ijin
                       7 pilihan = $message[6]  -> nis # all
                       8 arraynis = $message[7]  -> 250001:250002
                       9 Keterangan = $message[8]  -> Keterangan
                       10 xxxxxxx = $message[9]  -> xxxxxxxxxxxx
                    */

                $pesan = explode('/', $message);
                $kelasPesan = $pesan[3];
                $jenis_absen = $pesan[4];
                $absen = $pesan[5];
                $pilihan = $pesan[6];
                $ArrayNisAsli = $pesan[7];
                $keterangan = $pesan[8];
                $jm = count($pesan);
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage('GuruId', '6285329860005', (string)$jm);
                $kelas = Ekelas::where('kelas', $kelasPesan)->first();
                if ($pilihan === 'All') {
                    $Siswas = Detailsiswa::where('kelas_id', $kelas->id)->get();
                } else {
                    $ArrayNis = explode(':', $ArrayNisAsli);
                    $Siswas = Detailsiswa::whereIn('nis', $ArrayNis)->get();
                }
                foreach ($Siswas as $siswa) {
                    $attributes = [
                        'detailsiswa_id'    => $siswa->id,
                        'tapel_id'          => $tapel->id,
                        'semester'          => $tapel->semester ?? '1',
                        'kelas_id'          => $kelas->id ?? null,
                        'jenis_absen'       => $jenis_absen ?? null,
                    ];
                    $values = [
                        'absen'             => $absen,
                        'waktu_absen'       => now(),
                        'updated_at'        => now(),
                    ];
                    // Update jika ada, buat baru kalau tidak ada
                    Eabsen::updateOrCreate($attributes, $values);
                    // Pengiriman pesan ke orang tua
                    $data = [
                        // 'telat'          => $telatMenit,
                        'detailsiswa_id'    => $siswa->id,
                        'tapel_id'          => $tapel->id,
                        'semester'          => $tapel->semester ?? '',
                        'kelas_id'          => $kelas->id ?? null,
                        'absen'             => $absen,
                        'jenis_absen'       => $jenis_absen ?? null,
                        'waktu_absen'       => now(),
                        'updated_at'        => now(),
                    ];

                    if (!config('whatsappSession.WhatsappDev')) {
                        if (!config('whatsappSession.SingleSession')) {
                            $sessions = getWaSession($siswa->tingkat_id);
                        } else {
                            $sessions = getWaSession();
                        }
                        $NoTujuan = getNoTujuanOrtu($siswa);
                    } else {
                        $sessions = config('whatsappSession.IdWaUtama');
                        $NoTujuan = config('whatsappSession.DevNomorTujuan');
                    }
                    $pesanKiriman = AbsensiPulangCepat($siswa,  $keterangan);
                    $PesanKirim = format_pesan('Informasi Kepulangan Siswa', $pesanKiriman);
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $PesanKirim);
                }
                break;
            case 'Pulang Cepat':
                //  Pulang Cepat / Guru / Kode Guru / Keterangan
                $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                /*
                   $kode = $pesan[0];  -> Pulang Cepat
                   $hak = $pesan[1];  -> Guru
                   $kode_guru = $pesan[2];  -> xxxxxxxxxxxx
                   $keterangan = $pesan[3];  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[4];  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[5];  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[6];  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[7];  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[8];  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[9];  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[10];  -> xxxxxxxxxxxx
                */
                $keterangan = $pesan[3];
                if (!config('whatsappSession.WhatsappDev')) {
                    $siswas = Detailsiswa::where('status_siswa', 'aktif')->get();
                } else {
                    $siswas = Detailsiswa::where('status_siswa', 'aktif')->limit(5)->get();
                }
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage('Siswa', '6285329860005', json_encode($siswas));
                // return;
                foreach ($siswas as $siswa):
                    $PesanKirim = format_pesan('Informasi Kepulangan', AbsensiPulangCepat($siswa,  $keterangan));
                    if (!config('whatsappSession.WhatsappDev')) {
                        if (!config('whatsappSession.SingleSession')) {
                            $sessions = getWaSession($siswa->tingkat_id);
                        } else {
                            $sessions = getWaSession();
                        }
                        $NoTujuan = getNoTujuanOrtu($siswa);
                    } else {
                        $sessions = config('whatsappSession.IdWaUtama');
                        $sessions = 'Siswa';
                        $NoTujuan = config('whatsappSession.DevNomorTujuan');
                    }
                    // $result = \App\Models\Whatsapp\WhatsApp::sendMessage('Siswa', '6285329860005', '$PesanKirim');
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $PesanKirim);
                    sleep(rand(5.10));
                endforeach;

                break;
            case 'Kontak Sekolah':
                //Kontak Sekolah / Guru / Kode Guru
                $isiPesan = kontakSekolah();
                $pesanKiriman = format_pesan('Data Link Website Saat Ini', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Kontak Kosong':

                // Kontak Kosong / Guru / Kode Guru
                // Kontak Kosong / Guru / AN
                $NoAyah = Detailsiswa::with('kelasOne')
                    ->where(function ($query) {
                        $query->whereNull('ayah_nohp')
                            ->orWhere('ayah_nohp', '');
                    })
                    ->get();

                $NoIbu = Detailsiswa::with('kelasOne')
                    ->where(function ($query) {
                        $query->whereNull('ibu_nohp')
                            ->orWhere('ibu_nohp', '');
                    })
                    ->get();

                $no_ibu = '';
                foreach ($NoIbu as $index => $ibu) {
                    $no = $index + 1;
                    $no_ibu .= "{$no}. {$ibu->nama_siswa} / {$ibu->kelasOne->kelas} \n";
                }
                $DataIbu = "Berikut ini kontak *Ibu* yang kosong : \n{$no_ibu}";
                $no_ayah = '';
                foreach ($NoAyah as $index => $ayah) {
                    $no = $index + 1;
                    $no_ayah .= "{$no}. {$ayah->nama_siswa} / {$ayah->kelasOne->kelas}  \n";
                }
                $DataAyah = "Berikut ini kontak *Ayah* yang kosong : \n{$no_ayah}";
                $isiPesan =
                    "📬 *Berikut data kontak terkait no HP orang tua :*\n\n" .
                    "{$DataIbu}\n {$DataAyah}" .
                    "";
                $pesanKiriman = format_pesan('Data Kontak Orang Tua', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Link Absen':
                // Link Absen / Guru / Kode Guru
                $baseUrl = config('whatsappSession.UrlAbsen'); // Pastikan sudah termasuk "http://" atau "https://"
                $siswa = $baseUrl . "absen-siswa-ajax";
                $Ipabsensi  = "192.168.1.29";
                $siswalocal  = config('app.name') . "absen-guru-ajax";
                $siswa = config('app.url_online') . "/absensi/absen-siswa-ajax";
                $guru  = config('app.url_online') . "/absensi/absen-guru-ajax";
                $guru  = config('app.url_online') . "/absensi/absen-guru-ajax";
                if (!config('whatsappSession.ngRok')) {
                    $isiPesan =
                        "📌 Berikut link absensi Local:\n\n" .
                        "👨‍🎓 Ip Akses:\n $Ipabsensi\n\n" .
                        "👨‍🏫 Silahkan pilih absensi untuk guru atau siswa :\n";
                } else {
                    $isiPesanonline =
                        "📌 Berikut link absensi:\n\n" .
                        "👨‍🎓 Siswa:\n $siswa\n\n" .
                        "👨‍🏫 Guru:\n $guru";
                    $isiPesanoffline =
                        "📌 Berikut link absensi Local:\n\n" .
                        "👨‍🎓 Ip Akses:\n $Ipabsensi\n\n" .
                        "👨‍🏫 Silahkan pilih absensi untuk guru atau siswa :\n";
                    $isiPesan =
                        "{$isiPesanonline}\n{$isiPesanoffline}" .
                        "Untuk Mode jaringan local :\n" .
                        "- Pastikan terhubung dengan jaringan / wifi yang sama\n" .
                        "- Buka aplikasi *Google Chrome*\n" .
                        "- Silahkan ketik Ip Akses pada input url\n" .
                        "\n";
                }

                $pesanKiriman = format_pesan('Data Link Absensi', $isiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Teruskan':
                // Teruskan / Guru / Kode Guru / ArrayNis / ortu # siswa / Isi Pesan / Call
                /*
                   xxxxxxx = $pesan[0]  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[1]  -> xxxxxxxxxxxx
                   $kodeguru = $pesan[2]  -> xxxxxxxxxxxx
                   $ArrayNis = $pesan[3]  -> xxxxxxxxxxxx
                   $pilihan = $pesan[4]  -> xxxxxxxxxxxx
                   $isiPesanWa = $pesan[5]  -> xxxxxxxxxxxx
                   $Call = $pesan[6]  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[7]  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[8]  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[9]  -> xxxxxxxxxxxx
                   xxxxxxx = $pesan[10]  -> xxxxxxxxxxxx
                */
                $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
                $kodeguru = $pesan[2];
                $ArrayNis = explode(':', $pesan[3]);
                $pilihan = $pesan[4];
                $isiPesanWa = $pesan[5];
                $Call   = null;
                $Nocall = null;
                if (isset($pesan[6])) {
                    $Call   = strtolower($pesan[6]);
                    $Nocall = $NoRequest;
                }
                $Guru = Detailguru::where('kode_guru', $kodeguru)->first();
                $Siswas = Detailsiswa::whereIn('nis', $ArrayNis)->get();
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, '$pesanKiriman');
                foreach ($Siswas as $siswa) {
                    if ($pilihan === 'siswa') {
                        $NoTujuan = $siswa->nohp_siswa;
                        $isiPesan =
                            "📌 Berikut ini informasi pemberitahuan untuk *Ananda {$siswa->nama_siswa}*\n" .
                            "*Ananda {$siswa->nama_siswa}* menyampaikan :\n{$isiPesanWa}\n" .
                            "\n";
                    } else {
                        $NoTujuan = getNoTujuanOrtu($siswa);
                        $sapaan = $Guru->jenis_kelamin === 'Perempuan' ? 'Ibu' : 'Bapak';
                        $Varcall = $Nocall
                            ? "Mohon segera menghubungi ke \n {$sapaan} {$Guru->nama_guru},{$Guru->gelar} - {$Nocall}"
                            : '';

                        $isiPesan =
                            "📌 Berikut ini informasi pemberitahuan untuk Bapak / Ibu wali dari *Ananda {$siswa->nama_siswa}*\n" .
                            "{$isiPesanWa}\n" .
                            "{$Varcall}\n" .
                            "\n";
                    }
                    if (!config('whatsappSession.WhatsappDev')) {
                        if (!config('whatsappSession.SingleSession')) {
                            $sessions = getWaSession($siswa->tingkat_id);
                        } else {
                            $sessions = getWaSession();
                        }
                    } else {
                        $sessions = config('whatsappSession.IdWaUtama');
                        $NoTujuan = config('whatsappSession.DevNomorTujuan');
                    }
                    $pesanKiriman = format_pesan('Data Link Absensi', $isiPesan);
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $pesanKiriman);
                }
                break;
            case 'Registrasi Guru':
                // Ijin Siswa / Siswa / 2025001 / Ijin / Keterangan
                // $baris = preg_split("/\r\n|\n|\r/", $message);
                $baris = preg_replace("/\r\n|\n|\r/", "/", $message);
                $PesanKirim =
                    "Iya, server aktif\n" .
                    "Axxxxxxxxxxxxx\n" .
                    "{$baris}";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Informasi', $PesanKirim));
                break;
            case 'Cek Server':
                // Ijin Siswa / Siswa / 2025001 / Ijin / Keterangan
                $PesanKirim =
                    "Iya, server aktif\n" .
                    "Apakah ada yang bisa di bantu???";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Informasi', $PesanKirim));
                break;
            case 'Dokumen Siswa':
                // Dokumen Siswa / Guru / 230019 / karpel # foto # kk # nisn # ktp ayah # ktp ibu # ijazah # ijazah sd # kia # bantuan 1 # bantuan 2 # bantuan 3 # bantuan 4 # bantuan 5
                $pesan = explode('/', $message);
                // $dok = explode(':', $pesan[3]);
                $Siswa = Detailsiswa::with('KelasOne')->where('nis', $pesan[2])->first();
                $nama_siswa    = ucwords(strtolower($Siswa->nama_siswa));
                $nama_panggilan = ucwords(strtolower($Siswa->nama_panggilan));
                $dok = strtolower($pesan[3]);
                if ($dok === 'foto') {
                    $filename = $Siswa->nis . '-3x4.png';
                    $caption =
                        "Berikut data foto dari ananda {$nama_siswa}\n" .
                        "Nama Lengkap : {$nama_siswa}\n" .
                        "Nama Panggilan: {$nama_panggilan}\n" .
                        "NIS: {$Siswa->nis}\n" .
                        "NISN: {$Siswa->nisn}\n";
                    CopyFileWa($filename, 'img/siswa/foto');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Data Siswa', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'karpel') {
                    $filename = $Siswa->nis . '.png';
                    $tanggal = Carbon::create($Siswa->tanggal_lahir)->translatedformat('d F Y');
                    $caption =
                        "Data Karpel \n" .
                        "Nama Lengkap : {$nama_siswa}\n" .
                        "Nama Panggilan: {$nama_panggilan}\n" .
                        "NIS: {$Siswa->nis}\n" .
                        "NISN: {$Siswa->nisn}\n" .
                        "TTL: {$Siswa->tempat_lahir}, {$tanggal}\n" .
                        "Alamat: Rt {$Siswa->rt}, Rw {$Siswa->rw}, Desa {$Siswa->desa}\n" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/karpel/');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Data Karpel Depan', $caption), $filePath);
                    CopyFileWa('belakang_' . $filename, 'img/siswa/karpel/');
                    $filePath = base_path('whatsapp/uploads/belakang_' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Data Karpel Belakang', $caption), $filePath);
                } else if ($dok === 'kk') {
                    $filename = $Siswa->nis . '.png';
                    $tanggal = Carbon::create($Siswa->tanggal_lahir)->translatedformat('d F Y');
                    $caption =
                        "Data Kartu Keluarga \n" .
                        "Nama Lengkap : {$nama_siswa}\n" .
                        "Nama Panggilan: {$nama_panggilan}\n" .
                        "No NIK: {$Siswa->nik}\n" .
                        "No KK: {$Siswa->kk}\n" .
                        "Nama Ayah: {$Siswa->ayah_nama}\n" .
                        "Nama Ibu: {$Siswa->ibu}\n" .
                        "Alamat: Rt {$Siswa->rt}, Rw {$Siswa->rw}, Desa {$Siswa->desa}\n" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/kk');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Data Kartu Keluarga', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'ktp ayah') {
                    $filename = 'ayah_' . $Siswa->nis . '.png';
                    $caption =
                        "Nama Lengkap : {$nama_siswa}\n" .
                        "Nama Panggilan: {$nama_panggilan}\n\n" .
                        "*Data Ayah*\n" .
                        "Nama Ayah: {$Siswa->ayah_nama}\n" .
                        "No NIK: {$Siswa->nik}\n" .
                        "No KK: {$Siswa->kk}\n" .
                        "Alamat: {$Siswa->ayah_alamat}\n" .
                        "Pekerjaan: {$Siswa->ayah_pekerjaan}\n" .
                        "Alamat: Rt {$Siswa->ayah_rt}, Rw {$Siswa->ayah_rw}, Desa {$Siswa->ayah_desa}\n" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/ktp-ortu');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Data KTP Ayah', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'ktp ibu') {
                    $filename = 'ibu_' . $Siswa->nis . '.png';
                    $caption =
                        "Nama Lengkap : {$nama_siswa}\n" .
                        "Nama Panggilan: {$nama_panggilan}\n\n" .
                        "*Data Ayah*\n" .
                        "Nama Ayah: {$Siswa->ibu_nama}\n" .
                        "No NIK: {$Siswa->nik}\n" .
                        "No KK: {$Siswa->kk}\n" .
                        "Alamat: {$Siswa->ibu_alamat}\n" .
                        "Pekerjaan: {$Siswa->ibu_pekerjaan}\n" .
                        "Alamat: Rt {$Siswa->ibu_rt}, Rw {$Siswa->ibu_rw}, Desa {$Siswa->ibu_desa}\n" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/ktp-ortu');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Data KTP Ayah', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'ijazah-sd') {
                    $filename = $Siswa->nis . '.png';
                    $caption =
                        "Nama Lengkap : {$nama_siswa}\n" .
                        "Nama Panggilan: {$nama_panggilan}\n\n" .
                        "*Data Ijazah*\n" .
                        "Sekolah Asal: {$Siswa->namasek_asal}\n" .
                        "No Ijazah: {$Siswa->nomor_ijazah_sd}\n" .
                        "Tanggal Ijazah: {$Siswa->tanggal_ijazah_sd}\n" .
                        "Lama Belajar: {$Siswa->lama_belajar} Tahun\n" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/ijazah-sd');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'ijazah') {
                    $filename = $Siswa->nis . '.png';
                    $caption =
                        "Nama Lengkap : {$nama_siswa}\n" .
                        "Nama Panggilan: {$nama_panggilan}\n\n" .
                        "*Data NISN*\n" .
                        "No Ijazah: {$Siswa->nisn}\n" .
                        "Tahun Lulus: {$Siswa->nisn}\n" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/ijazah');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'kia') {
                    $filename = $Siswa->nis . '.png';
                    $caption =
                        "Nama Lengkap : {$nama_siswa}\n" .
                        "Nama Panggilan: {$nama_panggilan}\n\n" .
                        "*Data KIA*\n" .
                        "NISN: {$Siswa->nisn}\n" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/ktp');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'nisn') {
                    $filename = $Siswa->nis . '.png';
                    $caption =
                        "Nama Lengkap : {$nama_siswa}\n" .
                        "Nama Panggilan: {$nama_panggilan}\n\n" .
                        "*Data NISN*\n" .
                        "NISN: {$Siswa->nisn}\n" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/nisn');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'bantuan 1') {
                    $filename = $Siswa->nis . '.png';
                    $caption =
                        "Berikut Data Bantuan PIP :" .
                        "Nama : {$Siswa->nama_siswa}" .
                        "Kelas : {$Siswa->KelasOne->kelas}" .
                        "No Kartu : {$Siswa->bantuan_1}" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/bantuan_1');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'bantuan 2') {
                    $filename = $Siswa->nis . '.png';
                    $caption =
                        "Berikut Data Bantuan PIP :" .
                        "Nama : {$Siswa->nama_siswa}" .
                        "Kelas : {$Siswa->KelasOne->kelas}" .
                        "No Kartu : {$Siswa->bantuan_2}" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/bantuan_2');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'bantuan 3') {
                    $filename = $Siswa->nis . '.png';
                    $caption =
                        $caption =
                        "Berikut Data Bantuan PIP :" .
                        "Nama : {$Siswa->nama_siswa}" .
                        "Kelas : {$Siswa->KelasOne->kelas}" .
                        "No Kartu : {$Siswa->bantuan_3}" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/bantuan_3');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'bantuan 4') {
                    $filename = $Siswa->nis . '.png';
                    $caption =
                        $caption =
                        "Berikut Data Bantuan PIP :" .
                        "Nama : {$Siswa->nama_siswa}" .
                        "Kelas : {$Siswa->KelasOne->kelas}" .
                        "No Kartu : {$Siswa->bantuan_4}" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/bantuan_4');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else if ($dok === 'bantuan 5') {
                    $filename = $Siswa->nis . '.png';
                    $caption =
                        $caption =
                        "Berikut Data Bantuan PIP :" .
                        "Nama : {$Siswa->nama_siswa}" .
                        "Kelas : {$Siswa->KelasOne->kelas}" .
                        "No Kartu : {$Siswa->bantuan_5}" .
                        "\n";
                    CopyFileWa($filename, 'img/siswa/bantuan_5');
                    $filePath = base_path('whatsapp/uploads/' . $filename);
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                } else {
                    $PesanKirim =
                        "Maaf tidak ada dokumen yang diminta / tersedia";
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $PesanKirim);
                }
                break;
            case 'Cek Tanggal Lahir':
                // Cek Tanggal Lahir / Guru / Kelas
                // Cek Tanggal Lahir / Guru / VIII A
                $pesanKe = explode('/', $message);
                $kelas = Ekelas::where('kelas', $pesanKe[2])->first();
                $Siswa = Detailsiswa::where('kelas_id', $kelas->id)->get();
                $Hasil = "Berikut Data Tanggal Lahir Pada Kelas {$pesanKe[2]} :\n";
                foreach ($Siswa as $data):
                    $tanggal_lahir = Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y');
                    $Hasil .= "- {$data->nama_siswa} ({$tanggal_lahir})\n";
                endforeach;
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Tanggal Lahir', $Hasil));
                // DokumenSiswa($sessions, $NoRequest, $message);
                break;
            case 'Cek Data Karpel':
                // Cek Tanggal Lahir / Guru / Kelas
                // Cek Tanggal Lahir / Guru / VIII A
                $pesanKe = explode('/', $message);
                $kelas = Ekelas::where('kelas', $pesanKe[2])->first();
                $Siswa = Detailsiswa::where('kelas_id', $kelas->id)->get();
                $Hasil = "Berikut Data Tanggal Lahir Pada Kelas {$pesanKe[2]} :\n";
                foreach ($Siswa as $data):
                    $tanggal_lahir = Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y');
                    $Hasil .= "- {$data->nama_siswa} ({$tanggal_lahir})\n";
                endforeach;
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Tanggal Lahir', $Hasil));
                // DokumenSiswa($sessions, $NoRequest, $message);
                break;
            case 'Dokumen pdf':
                $nis = $data[3];
                // Dokumen pdf / Guru / AS/ 230019 / kk:ijazah-sd:karpel
                // Dokumen pdf / Guru / AS/ 230019 /karpel : foto : kk : nisn : ktp ayah : ktp ibu : ijazah : ijazah sd : kia : bantuan 1 : bantuan 2 : bantuan 3 : bantuan 4 : bantuan 5/cetak
                $doc = explode(':', $data[4]);
                $doc = array_map(fn($d) => trim(strtolower($d)), $doc);

                // $path = gabung_gambar_ke_pdf($nis, $doc);
                $path = dokumen_lengkap_siswa($nis, $doc, true);
                sleep(10);
                CopyFileWa($nis . '.pdf', 'temp/pdf'); // public/temp
                $filename = $nis . '.pdf';
                $filePath = base_path('whatsapp/uploads/' . $filename);
                if (end($data) === 'cetak') {
                    py_print($filePath);
                }
                $caption =
                    "Dokumen siswa {$nis} sudah dibuat dan dikirim ✅\n" .
                    "\n\n";
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, format_pesan_gb('Dokumen Siswa', $caption), $filePath);
                hapusFileWhatsApp($filePath,  $filename);
                break;
            case 'Statistik Siswa':
                // Format: Statistik Siswa/Guru/23:24:25/pdf/cetak
                $kodeString = $data[2] ?? null;
                $kodeString = trim($kodeString ?? '');

                if (empty($kodeString)) {
                    $PesanKirim = "Format salah.\nGunakan: Statistik Siswa/Siswa/<prefix_nis_dipisah_dengan_titik_dua>\nContoh: Statistik Siswa/Siswa/23:24:25";
                    \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('judul', $PesanKirim));
                    break;
                }

                // pastikan mode pdf
                if (($data[3] ?? null) === 'pdf') {
                    $prefixList = explode(':', $kodeString);
                    $statistikData = [];

                    foreach ($prefixList as $prefix) {
                        $RekapSiswa = Detailsiswa::select('status_siswa', DB::raw('COUNT(*) as jumlah'))
                            ->where('nis', 'like', $prefix . '%')
                            ->groupBy('status_siswa')
                            ->orderBy('status_siswa')
                            ->get();

                        $total = $RekapSiswa->sum('jumlah');

                        // Siapkan dataset untuk grafik
                        $labels = $RekapSiswa->pluck('status_siswa');
                        $data = $RekapSiswa->pluck('jumlah');

                        // Warna tetap, agar per status konsisten
                        $colors = [
                            'lulus' => 'rgba(75, 192, 192, 0.8)',
                            'dropout' => 'rgba(255, 99, 132, 0.8)',
                            'aktif' => 'rgba(54, 162, 235, 0.8)',
                            'pindah' => 'rgba(255, 205, 86, 0.8)',
                            'lainnya' => 'rgba(201, 203, 207, 0.8)',
                        ];

                        $bgColors = [];
                        foreach ($labels as $status) {
                            $bgColors[] = $colors[strtolower($status)] ?? 'rgba(153, 102, 255, 0.8)';
                        }

                        // === Generate grafik via QuickChart ===
                        $chartConfig = [
                            "type" => "bar",
                            "data" => [
                                "labels" => $labels,
                                "datasets" => [[
                                    "label" => "Status Siswa Angkatan $prefix",
                                    "data" => $data,
                                    "backgroundColor" => $bgColors
                                ]]
                            ],
                            "options" => [
                                "plugins" => ["legend" => ["display" => false]],
                                "scales" => [
                                    "y" => ["beginAtZero" => true, "ticks" => ["precision" => 0]]
                                ]
                            ]
                        ];

                        $chartResponse = \Illuminate\Support\Facades\Http::get('https://quickchart.io/chart', [
                            'c' => json_encode($chartConfig),
                            'format' => 'base64',
                            'backgroundColor' => 'white'
                        ]);

                        $chartBase64 = $chartResponse->successful() ? $chartResponse->body() : null;

                        $statistikData[] = [
                            'prefix' => $prefix,
                            'total' => $total,
                            'data' => $RekapSiswa,
                            'chartBase64' => $chartBase64,
                        ];
                    }

                    // ==========================
                    // 💾 Generate PDF pakai DomPDF
                    // ==========================
                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('role.alumni.data-alumni', [
                        'judul' => 'DATA STATISTIK SISWA BERDASARKAN STATUS',
                        'statistik' => $statistikData,
                        'tanggal' => now()->format('d/m/Y H:i'),
                    ])->setPaper('a4', 'portrait');

                    $filename = 'statistik_siswa_' . date('Ymd_His') . '.pdf';
                    $savePath = base_path("whatsapp/uploads/{$filename}");
                    $pdf->save($savePath);

                    // ==========================
                    // 📩 Kirim notifikasi WhatsApp
                    // ==========================
                    $caption = "📊 Statistik siswa berhasil dibuat!\n\nBerikut adalah data tabel dan grafik statistik yang diminta.";
                    $pesan = explode("/", $message);
                    $terakhir = end($pesan);

                    if ($terakhir === "cetak") {
                        $result = print_docx($savePath);
                        $PesanKirim =
                            "🖨️ Data telah dikirim ke printer. Pastikan printer aktif dan terhubung.\n" .
                            "- Printer dengan tinta dan hasil cetak normal.\n" .
                            "- Pastikan printer yang digunakan adalah default dan terhubung.\n" .
                            "\n\n";
                        \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Statistik Data Siswa', $PesanKirim));
                    } else {
                        \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $savePath);
                    }

                    return response()->json([
                        'status' => 'ok',
                        'file' => $filename,
                    ]);
                }

                break;

            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
