<?php

use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use App\Models\Absensi\EabsenGuru;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Artisan;

/*
    |----------------------------------------------------------------------
    | 📌 Helper Auto_Reply_KepalaHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('Auto_Reply_KepalaHelper')) {
    function Auto_Reply_KepalaHelper($Kode, $NoRequest, $message)
    {
        $NoTujuan = config('whatsappSession.NoKepala');
        $sessions = config('whatsappSession.IdWaUtama');
        $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
        /*
           $Kode = $pesan[0];  -> xxxxxxxxxxxx
           $Target = $pesan[1];  -> Kepala
        */
        switch ($Kode) {
            case 'Laporan Absensi':
                # code...

                $output = laporan_absensi_guru();
                $PesanKirim =
                    "$output \n" .
                    "\n";

                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, "6285329860005", format_pesan('Laporan Absensi', $PesanKirim));
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Laporan Absensi', $PesanKirim));
                break;
            case 'LBKG':
                # code...
                // LBKG / Kepala / Kode Guru / Bulan
                /*
                    $kode_guru = $pesan[2];  -> xxxxxxxxxxxx
                    $bulan = $pesan[3];  -> xxxxxxxxxxxx
                    $xxxxxxx = $pesan[4];  -> xxxxxxxxxxxx
                    $xxxxxxx = $pesan[5];  -> xxxxxxxxxxxx
                    $xxxxxxx = $pesan[6];  -> xxxxxxxxxxxx
                    $xxxxxxx = $pesan[7];  -> xxxxxxxxxxxx
                    $xxxxxxx = $pesan[8];  -> xxxxxxxxxxxx
                    $xxxxxxx = $pesan[9];  -> xxxxxxxxxxxx
                    $xxxxxxx = $pesan[10];  -> xxxxxxxxxxxx
                */
                $kode_guru = $pesan[2];
                $bulan = $pesan[3];
                $output = absensi_guru_bulanan($kode_guru, $bulan);
                $PesanKirim =
                    "$output \n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, "6285329860005", format_pesan('Laporan Absensi', $PesanKirim));
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Laporan Absensi', $PesanKirim));
                break;
            default:
                # code...
                break;
        }
        return "Helper Auto_Reply_KepalaHelper dijalankan dengan param: ";
    }
}


if (!function_exists('absensi_guru_bulanan')) {
    function absensi_guru_bulanan($kode_guru, $bulan)
    {
        // $tanggal = $bulan ? Carbon::parse($bulan)->toDateString() : now()->toDateString();

        $DataGuru = Detailguru::where('kode_guru', $kode_guru)->first();
        // Ambil semua absensi guru tanggal tersebut, eager load guru
        $AbsGurus = EabsenGuru::with('guru')
            ->where('detailguru_id', $DataGuru->id)
            ->whereMonth('created_at', $bulan)
            ->OrderBy('created_at', 'DESC')
            ->get()
            ->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->created_at)->toDateString();
            });

        $RekapTelat = EabsenGuru::with('guru')
            ->where('detailguru_id', $DataGuru->id)
            ->whereMonth('created_at', $bulan)
            ->OrderBy('created_at', 'DESC')
            ->sum('telat');
        $namaBulan = bulanIndo($bulan);
        $jam = number_format($RekapTelat / 60, 2);
        $HitunganTelat =
            "*Akumulasi Waktu Telat :*\n" .
            "Akumulasi telat dalam bulan $namaBulan : \n{$RekapTelat} Menit / {$jam} Jam \n" .
            "\n" . str_repeat("─", 25) . "\n";
        $pesan = '';
        $pesan .= "\n" . str_repeat("_", 35) . "\n";
        $pesan .= "Nama Guru : *{$DataGuru->nama_guru}, {$DataGuru->gelar}*\n";
        $pesan .= str_repeat("_", 35) . "\n";

        foreach ($AbsGurus as $tanggal => $listAbsensi) {
            $tglFormat = \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y');
            $pesan .= "\n📅 {$tglFormat} :\n";

            foreach ($listAbsensi as $AbsGuru) {
                $waktu = Carbon::parse($AbsGuru->created_at)->format('H:i');
                $jenis_absen = ucfirst($AbsGuru->jenis_absen);

                $absenTime = Carbon::parse($AbsGuru->created_at);
                $batasWaktu = Carbon::parse($AbsGuru->created_at)->setTime(7, 5);

                // hasil selalu integer, tapi kita jaga-jaga pakai round
                $selisihMenit = (int) round($absenTime->diffInMinutes($batasWaktu, false));

                if ($AbsGuru->jenis_absen === 'masuk') {
                    if ($selisihMenit >= 35) {
                        $icon = $AbsGuru->telat > 0 ? "🏆" : "⚠️";
                        $waktucepat = $selisihMenit - 35;
                        $berangkatAwal = "\n\t\t\t🏆 Lebih Cepat {$waktucepat} m (*MC*)";
                        $keterangan = "{$berangkatAwal}";
                    } elseif ($selisihMenit > 25) {
                        $icon = $AbsGuru->telat > 0 ? "⚠️" : "✅";
                        $keterangan = "{$selisihMenit} m (*MN*)";
                    } elseif ($selisihMenit >= 0) {
                        $icon = $AbsGuru->telat > 0 ? "✅" : "⚠️";
                        $keterangan = "{$selisihMenit} m (*MN*)";
                    } else {
                        $icon = $AbsGuru->telat > 0 ?  "✅" : "⚠️";
                        $keterangan = "{$selisihMenit} m *(MT)*";
                    }
                } else {
                    $absenTimePulang = Carbon::parse($AbsGuru->created_at);
                    $batasWaktuPulang = Carbon::parse($AbsGuru->created_at)->setTime(13, 15);
                    $selisihMenit = (int) round($absenTime->diffInMinutes($batasWaktuPulang, false));
                    if ($AbsGuru->pulang_telat >= 60) {
                        $icon = $AbsGuru->pulang_telat >= 60 ? "🏆 " : "⚠️";
                        $datatelat = $AbsGuru->pulang_telat - 60;
                        $lembur = "\n\t\t\t🏆 Lembur {$datatelat} *(L)*";
                        $keterangan = "{$lembur} / {$AbsGuru->datatelat} ";
                    } elseif ($AbsGuru->pulang_telat > 0) {
                        $icon = $AbsGuru->pulang_telat > 0 ? "✅" : "⚠️";
                        $lembur = "Pulang cepat";
                        $keterangan = "{$AbsGuru->pulang_telat} *(PN)*";
                    } else {
                        $icon = $AbsGuru->pulang_cepat > 0 ? "⚠️" : "✅ ";
                        $lembur = "{$selisihMenit} m";
                        $keterangan = "{$lembur} (*PC*)";
                    }
                }

                $pesan .= "   {$icon} {$jenis_absen} / {$waktu} WIB / {$keterangan}\n";
            }
        }


        $catatan =
            "*Catatan :* \n" .
            "*- Format Baca* : \nKode Guru / Waktu Absensi / Selisih \n" .
            "*- Waktu absen Masuk* \t\t\t: 07:00 WIB \n" .
            "*- Waktu absen Pulang* \t\t\t: 13:00 WIB \n" .
            "*- Toleransi* \t\t\t\t\t\t\t\t\t\t: 5 Menit\n" .
            "*- Informasi Icon* \t\t\t\t\t\t:\n" .
            "✅ \t\t\t\t\t: Tidak telat\n" .
            "⚠️ \t\t\t\t\t: Telat\n" .
            "(*MN*): Masuk Normal\n" .
            "(*MT*): Masuk Telat\n" .
            "(*PC*): Pulang Cepat\n";
        "(*PN*): Pulang Normal\n";

        $sessions = config('whatsappSession.IdWaUtama');
        $NoTujuan = !config('whatsappSession.WhatsappDev')
            ? config('whatsappSession.NoKepala')
            : config('whatsappSession.DevNomorTujuan');

        $PesanKirim =
            "Berikut ini informasi laporan kehadiran guru : \n" .
            "{$pesan} \n\n" .
            "{$HitunganTelat} \n" .
            "{$catatan} \n\n";

        // Kirim pesan WA
        return $PesanKirim;
    }
}
if (!function_exists('laporan_absensi_guru')) {
    function laporan_absensi_guru($tanggal = null)
    {
        $tanggal = $tanggal ? Carbon::parse($tanggal)->toDateString() : now()->toDateString();

        // Ambil semua absensi guru tanggal tersebut, eager load guru
        $AbsGurus = EabsenGuru::with('guru')
            ->whereDate('created_at', $tanggal)
            ->get();

        $pesan = '';
        foreach ($AbsGurus as $AbsGuru) {
            $waktu = Carbon::parse($AbsGuru->created_at)->format('H:i');
            $jenis_absen = ucfirst($AbsGuru->jenis_absen);
            $absenTime = Carbon::parse($waktu);
            $batasWaktu = Carbon::parse('07:05');

            $selisihMenit = $absenTime->diffInMinutes($batasWaktu, false);
            // false supaya bisa negatif jika datang lebih awal

            $pesan .= "{$AbsGuru->guru->kode_guru} \t\t\t: {$jenis_absen} / {$waktu} WIB / {$selisihMenit} m\n";
        }

        $catatan =
            "*Catatan* \n" .
            "*Format Baca* : \nKode Guru / Waktu Absensi / Selisih \n" .
            "*Waktu absen* \t\t\t: 07:00 WIB \n" .
            "*Toleransi* \t\t\t\t\t: 5 Menit";

        $sessions = config('whatsappSession.IdWaUtama');
        $NoTujuan = !config('whatsappSession.WhatsappDev')
            ? config('whatsappSession.NoKepala')
            : config('whatsappSession.DevNomorTujuan');

        $PesanKirim =
            "Berikut ini informasi laporan kehadiran guru : \n" .
            "{$pesan} \n" .
            "{$catatan} \n\n";

        // Kirim pesan WA
        return $PesanKirim;
    }
}
