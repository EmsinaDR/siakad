<?php

use Carbon\Carbon;
use Illuminate\Support\Number;
use App\Models\Whatsapp\WhatsApp;
use App\Models\Absensi\EabsenGuru;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Http;
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
        if (!validate_Kepala($NoRequest)) {
            $PesanKirim =
                "Mohon maaf Bapak / Ibu / Saudara *_Tidak Berhak Akses Data_*.\nData ini khusus bagiannya masing - masing." .
                "Terima Kasih.";
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Informasi!!!', $PesanKirim));
            $PesanKirim =
                "Ada yang mencoba akses ke data {$Kode} dari {$NoRequest}\n" .
                "Terima Kasih.";
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, config('whatsappSession.SekolahNoTujuan'), format_pesan('Laporan Akses', $PesanKirim));
            return false;
        }
        switch ($Kode) {
            case 'Tester':
                $PesanKirim =
                    "Kode Berjalan\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Laporan Absensi', $PesanKirim));
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Laporan Absensi', $PesanKirim));
                break;
            case 'Laporan Absensi':
                # code...

                $output = laporan_absensi_guru();
                $PesanKirim =
                    "$output \n" .
                    "\n";

                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Laporan Absensi', $PesanKirim));
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Laporan Absensi', $PesanKirim));
                break;
            case 'EAG':
                /*
                EAG ( Eksport Absensi Guru )
                EAG/Kepala/Kode Guru/Bulan
                */
                # code...
                $kode_guru = $pesan[2];
                $bulan = $pesan[3] ?? null;
                $DataAbsen = exportlaporan($kode_guru, $bulan);
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, "6285329860005", format_pesan('Laporan Absensi', json_encode($DataAbsen)));
                $dataTambahan = [
                    'data' => '$DataAbsen'
                ];
                $dataIdentitas = DataIdentitas();
                $data = array_merge($dataTambahan, [
                    'DataAbsen' => $DataAbsen
                ], $dataIdentitas);

                $folder = public_path('temp/export/absensi');
                $view = 'role.absensi.eabsenguru.export-excel-absensi-guru'; // Contoh = role.program.surat.siswa.surat-pindah-sekolah
                $filename = 'Rekap Absensi Kode Guru ' . $kode_guru . ' - ' . bulanIndo($bulan);
                $hasil = DomExport($filename, $data, $view, $folder);
                $respon = CopyFileWa($filename . '.pdf', 'temp/export/absensi');
                // $output = laporan_absensi_guru();
                // $hasil = json_encode($respon);
                $PesanKirim =
                    "File Export Laporan Absensi {$kode_guru} \n" .
                    "\n";
                $filename = $filename . '.pdf';
                $filePath = base_path('whatsapp/uploads/' . $filename);
                if (end($pesan) === 'cetak') {
                    py_print($filePath);
                }
                $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $PesanKirim, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp

                break;
            case 'EAGS':
                //EAGS / Kepala / DT:JM / 10 / cetak
                $ArrayKodeGuru = explode(":", $pesan[2]);
                $PesanKirim = "Mohon tunggu proses akan segera dilaksanakan dan membutuhkan waktu serta jeda setiap prosesnya";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Laporan Absensi', $PesanKirim));
                foreach ($ArrayKodeGuru as $kode_guru) {
                    $bulan = $pesan[3] ?? null;
                    $DataAbsen = exportlaporan($kode_guru, $bulan);

                    $dataTambahan = [
                        'data' => $DataAbsen
                    ];
                    $dataIdentitas = DataIdentitas();
                    $data = array_merge($dataTambahan, [
                        'DataAbsen' => $DataAbsen
                    ], $dataIdentitas);

                    $folder = public_path('temp/export/absensi');
                    $view = 'role.absensi.eabsenguru.export-excel-absensi-guru';
                    $filename = 'Rekap Absensi Kode Guru ' . $kode_guru . ' - ' . bulanIndo($bulan);

                    DomExport($filename, $data, $view, $folder);
                    CopyFileWa($filename . '.pdf', 'temp/export/absensi');
                    sleep(10);
                    // $filename = 'contoh.jpg';
                    $filename = $filename . '.pdf';
                    $filePath = base_path('whatsapp/uploads/' . $filename);

                    if (end($pesan) === 'cetak') { // Ganti Array pesan
                        py_print($filePath);
                    }
                    $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $filename, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
                    // sleep(10);
                    //Pastikan printer default sudah diseeting
                    // $filePath = base_path('whatsapp/uploads/' . $filename);
                }
                $filename = $filename;
                $FileKiriman  = base_path('whatsapp/uploads/' . $filename);
                hapusFileWhatsApp($FileKiriman, $filename);
                $PesanKirim = "Semua telah selesai";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Laporan Absensi', $PesanKirim));
                break;
            case 'LABG':
                # code...
                // LABG / Kepala / Kode Guru / Bulan
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
                $bulan = $pesan[3] ?? null;
                $output = absensi_guru_bulanan($kode_guru, $bulan);
                $PesanKirim =
                    "$output \n" .
                    "\n";

                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Laporan Absensi', $PesanKirim));
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Laporan Absensi', $PesanKirim));
                break;
            default:
                # code...
                break;
        }
        return "Helper Auto_Reply_KepalaHelper dijalankan dengan param: ";
    }
}

if (!function_exists('exportlaporan')) {
    function exportlaporan($kode, $bulan)
    {
        //Isi Fungsi
        $tapel = tapel();
        $DataGuru = Detailguru::where('kode_guru', $kode)->first();
        // Ambil semua absensi guru tanggal tersebut, eager load guru
        // $AbsGurus = EabsenGuru::with('guru')
        //     ->where('tapel_id', $tapel->id)
        //     ->where('detailguru_id', $DataGuru->id)
        //     ->whereMonth('created_at', $bulan)
        //     ->orderBy('created_at', 'ASC')
        //     ->get()
        //     ->groupBy('waktu_absen'); // pakai field waktu_absen biar lebih pas
        $AbsGurus = EabsenGuru::with('guru')
            ->where('tapel_id', $tapel->id)
            ->where('detailguru_id', $DataGuru->id)
            ->whereMonth('created_at', $bulan)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->map(function ($absen) {
                $hari = $absen->created_at->translatedFormat('l');

                // Tambahkan field tambahan ke masing-masing record
                $absen->waktu_absen = $absen->created_at->format('H:i');
                $absen->jam_masuk = '07:00';
                $absen->jam_pulang = match ($hari) {
                    'Senin'  => '13:15',
                    'Jumat'  => '11:00',
                    'Sabtu'  => '12:30',
                    default  => '13:00',
                };

                return $absen;
            })
            ->groupBy(fn($absen) => $absen->created_at->format('Y-m-d'))
            ->map(function ($absensis) {
                $masuk = $absensis->firstWhere('jenis_absen', 'masuk');
                $pulang = $absensis->firstWhere('jenis_absen', 'pulang');

                // Hitung durasi
                $durasi = ($masuk && $pulang)
                    ? Number::forHumans($masuk->created_at->diffInMinutes($pulang->created_at) / 60) . ' Jam / ' . Number::forHumans($masuk->created_at->diffInMinutes($pulang->created_at)) . '  menit'
                    : '-';

                // Tambahkan durasi ke semua record di hari itu
                foreach ($absensis as $absen) {
                    $absen->durasi = $durasi;
                }

                return $absensis; // tetap semua record
            });

        return $AbsGurus;
    }
}

if (!function_exists('absensi_guru_bulanan')) {
    function absensi_guru_bulanan($kode_guru, $bulan)
    {
        // $tanggal = $bulan ? Carbon::parse($bulan)->toDateString() : now()->toDateString();
        $tapel = tapel();
        //$tapel->id
        //where('tapel_id', $tapel->id)->
        $DataGuru = Detailguru::where('kode_guru', $kode_guru)->first();
        // Ambil semua absensi guru tanggal tersebut, eager load guru
        $AbsGurus = EabsenGuru::with('guru')
            ->where('tapel_id', $tapel->id)
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
        $RekapPulangCepat = EabsenGuru::with('guru')
            ->where('detailguru_id', $DataGuru->id)
            ->whereMonth('created_at', $bulan)
            ->OrderBy('created_at', 'DESC')
            ->sum('pulang_cepat');
        $RekapPulangTelat = (EabsenGuru::with('guru')
            ->where('detailguru_id', $DataGuru->id)
            ->whereMonth('created_at', $bulan)
            ->OrderBy('created_at', 'DESC')
            ->sum('pulang_telat')) * -1;
        $namaBulan = bulanIndo($bulan);
        $jam = number_format($RekapTelat / 60, 2);
        $jamPulangCepat = number_format($RekapPulangCepat / 60, 2);
        $jamPulangTelat = number_format($RekapPulangTelat / 60, 2);
        $HitunganTelat =
            "*Akumulasi Waktu bulan $namaBulan :*\n" .
            "*Telat* : \n{$RekapTelat} Menit / {$jam} Jam \n" .
            "*Pulang Cepat* : \n{$RekapPulangCepat} Menit / {$jamPulangCepat} Jam \n" .
            "*Pulang Telat* : \n{$RekapPulangTelat} Menit / {$jamPulangTelat} Jam \n" .
            "\n" . str_repeat("─", 25) . "\n";
        $pesan = '';
        $pesan .= "\n" . str_repeat("_", 35) . "\n";
        $pesan .= "👨‍🏫 Nama Guru : *{$DataGuru->nama_guru}, {$DataGuru->gelar}*\n";
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
                        $icon = $selisihMenit > 25 ? "✅" : "⚠️";
                        $keterangan = "{$selisihMenit} m (*MN*)";
                    } elseif ($selisihMenit >= 0) {
                        $icon = $selisihMenit > 0 ? "✅" : "⚠️";
                        $keterangan = "{$selisihMenit} m (*MN*)";
                    } else {
                        $icon = $AbsGuru->telat > 0 ?  "✅" : "⚠️";
                        $keterangan = "{$selisihMenit} m *(MT)*";
                    }
                } else {
                    $absenTimePulang = Carbon::parse($AbsGuru->created_at);
                    $batasWaktuPulang = Carbon::parse($AbsGuru->created_at)->setTime(13, 15);
                    $selisihMenit = (int) round($absenTime->diffInMinutes($batasWaktuPulang, false));
                    if ($AbsGuru->pulang_telat >= -60) {
                        $icon = $AbsGuru->pulang_telat >= -60 ? "✅ " : "⚠️";
                        $datatelat = $AbsGuru->pulang_telat - 60;
                        $lembur = "\n\t\t\t🏆 Lembur {$datatelat} *(L)*";
                        $keterangan = "{$lembur} / {$AbsGuru->datatelat} ";
                    } elseif ($AbsGuru->pulang_telat >= 0) {
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
            "📝 *Catatan :* \n" .
            // "*- Format Baca* : \nKode Guru / Waktu Absensi / Selisih \n" .
            "*- Waktu absen Masuk* \t\t\t: 07:00 WIB \n" .
            "*- Waktu absen Pulang* \t\t\t: 13:00 WIB \n" .
            "*- Toleransi* \t\t\t\t\t\t\t\t\t\t: 5 Menit\n" .
            "*- Informasi Icon* \t\t\t\t\t\t:\n" .
            "✅ \t\t\t\t\t: Tidak telat\n" .
            "⚠️ \t\t\t\t\t: Telat\n" .
            "(*MN*): Masuk Normal\n" .
            "(*MT*): Masuk Telat\n" .
            "(*PC*): Pulang Cepat\n" .
            "(*PN*): Pulang Normal\n" .
            "_Waktu selisih dalam detik_.\n";

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
// Tanggal kosong brrt hari ini All Guru
// Tanggal kosong brrt hari ini All Guru
if (!function_exists('laporan_absensi_guru')) {
    function laporan_absensi_guru($tanggal = null)
    {
        $tanggal = $tanggal ? Carbon::parse($tanggal)->format('Y-m-d') : now()->format('Y-m-d');

        $AbsGurus = EabsenGuru::with('guru')
            ->whereDate('created_at', $tanggal)
            ->get();

        // dd($tanggal, $AbsGurus->pluck('created_at')->toArray());

        // dd($AbsGurus->toArray());

        if ($AbsGurus->count() === 0) {

            $PesanKirim =
                "\nMohon maaf untuk saat ini *Belum Ada Data Tersedia* \n" .
                "\n\n";
        } else {
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
                "*Waktu Absen Masuk* \t\t\t: 07:00 WIB \n" .
                "*Waktu Absen Pulang* \t\t\t: \n" .
                "Masuk \t\t\t\t\t\t\t: 07:00 WIB \n" .
                "Pulang \t\t\t\t\t\t: 13:00 WIB \n" .
                "Jum'at \t\t\t\t\t\t\t: 11:15 WIB \n" .
                "Sabtu \t\t\t\t\t\t\t: 12:30 WIB \n" .
                "*Toleransi* \t\t\t\t\t: 5 Menit";
            // $sessions = config('whatsappSession.IdWaUtama');
            // $NoTujuan = !config('whatsappSession.WhatsappDev') ? config('whatsappSession.NoKepala') config('whatsappSession.DevNomorTujuan');
            $PesanKirim =
                "Berikut ini informasi laporan kehadiran guru : \n" .
                "{$pesan} \n" .
                "{$catatan} \n\n";
        }
        // Kirim pesan WA
        // dd($PesanKirim);
        return $PesanKirim;
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Rekap Absensi :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
    // Semua guru bulan September 2025
$data = getAbsensiPivot('2025-09');

// Hanya guru dengan kode GR001
$dataGuru = getAbsensiPivot('2025-09', 'GR001');
    */
// Proses Coding
// Array absensi guru

if (! function_exists('getAbsensiPivot')) {
    /**
     * Ambil data absensi guru dalam format pivot
     *
     * @param  string  $month   Format: YYYY-MM
     * @param  string|null  $kodeGuru   Kode guru, default null (semua)
     * @return array
     */
    function getAbsensiPivot($month, $kodeGuru = null)
    {
        $query = EabsenGuru::with('guru')
            ->whereMonth('created_at', date('m', strtotime($month)))
            ->whereYear('created_at', date('Y', strtotime($month)));

        if ($kodeGuru) {
            $query->whereHas('guru', function ($q) use ($kodeGuru) {
                $q->where('kode_guru', $kodeGuru);
            });
        }

        $AbsGurus = $query->orderBy('created_at')->get();

        $pivotData = $AbsGurus->groupBy(function ($abs) {
            return $abs->created_at->format('Y-m-d'); // group per tanggal
        })->map(function ($itemsByDate) {
            return $itemsByDate->groupBy(function ($abs) {
                return $abs->guru->kode ?? 'NA'; // group per kode guru
            })->map(function ($itemsByGuru) {
                $record = $itemsByGuru->first(); // ambil record pertama per hari

                return [
                    'tanggal'        => $record->created_at->format('Y-m-d'),
                    'kode_guru'      => $record->guru->kode ?? '-',
                    'nama_guru'      => $record->guru->nama ?? '-',
                    'masuk'          => $record->masuk ?? '-',
                    'telat'          => $record->telat ?? '-',
                    'pulang'         => $record->pulang ?? '-',
                    'pulang_cepat'   => $record->pulang_cepat ?? '-',
                    'pulang_telat'   => $record->pulang_telat ?? '-',
                    'absen_status'   => $record->status_absen ?? '-',
                ];
            });
        });

        return $pivotData->toArray();
    }
}
