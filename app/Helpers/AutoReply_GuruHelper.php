<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Admin\Ekelas;
use App\Models\Absensi\Eabsen;
use App\Models\Whatsapp\WhatsApp;
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
        // $sessions = config('whatsappSession.IdWaUtama');
        // $sessions = 'Siswa';
        $DevNomor = config('whatsappSession.DevNomorTujuan');
        if ($NoRequest !== $DevNomor) {
            if (!$Guru || $NoRequest !== $Guru->no_hp) {
                return \App\Models\Whatsapp\WhatsApp::sendMessage(
                    $sessions,
                    $NoRequest,
                    "Maaf anda tidak diijinkan akses disini"
                );
            }
        }
        if (!validateWhatsappAccess($NoRequest, $Guru)) {
            return; // stop eksekusi
        }
        // lanjut proses lainnya, karena guru valid atau dev
        switch (ucfirst($Kode)) {
            case 'Data Guru': // Data Guru/Guru/Kode_Guru
                // Log::info("Request received: NoRequest - $NoRequest, Nis - $nis dan Kode = $Kode");
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  DataKodeGuru($Guru->id));
                break;
            case 'Ijin Guru': // Ijin Guru/Guru/Kode_Guru
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  'Ijin Guru Diterima');
                break;
            case 'Jumlah Siswa': // Jumlah Siswa/Guru/Kode_Guru
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  JumlahSiswa(1));
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
                    $isi =
                        "Diberitahukan kepada orang tua wali dari *Ananda {$siswa->nama_siswa}*, pada hari ini {$hari}, dinyatakan *Ananda {$siswa->nama_siswa}* tidak mengikuti pelajaran *{$Mapel}*, karena tidak ada didalam kelas *tanpa keterangan / Bolos*.\n" .
                        "Atas perhatiannya kami sampaikan terima kasih" .
                        "\n";
                    $PesanKirim = format_pesan('Informasi Kehadiran Pelajaran', $isi);
                    // Ke Orang Tua
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($dataWa['sessions'], $dataWa['nomor'], $PesanKirim);
                }
                // Ke Wali Kelas
                // $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.WhatsappDev') ? config('whatsappSession.DevNomorTujuan')  : $siswa->KelasOne->Guru->no_hp;
                $sapaan = $siswa->KelasOne->Guru->jenis_kelamin === 'Perempuan' ? 'Ibu' : 'Bapak';
                $PesanKirimWalkes =
                    "Diberitahunkan kepada *{$sapaan} {$siswa->KelasOne->Guru->nama_guru},{$siswa->KelasOne->Guru->gelar}*, bahwasanya siswa kelas {$siswa->KelasOne->kelas} tidak mengikuti pelajaran tanpa keterangan / bolos.\n" .
                    "Berikut ini data yang siswanya :" .
                    "{$siswaBolos}\n" .
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
                $siswa = config('app.url') . "/siakad/public/absensi/absen-siswa-ajax";
                $guru  = config('app.url') . "/siakad/public/absensi/absen-guru-ajax";
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
                // Ijin Siswa / Siswa / 2025001 / Ijin / Keterangan
                DokumenSiswa($sessions, $NoRequest, $message);
                break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
