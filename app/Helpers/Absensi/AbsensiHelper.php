<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Absensi\Eabsen;
use App\Models\Admin\Identitas;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\DB;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;
/*
    |----------------------------------------------------------------------
    | 📌 Helper AbsensiHelper
    |----------------------------------------------------------------------
    |
*/

// Pesan Whatsapp
// Absensi dalam 1 hari
if (!function_exists('PesanAbsensi')) {
    function PesanAbsensi($id)
    {
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $faker = Faker::create();
        $Identitas = \App\Models\Admin\Identitas::first();

        $Siswa = Detailsiswa::with('Detailsiswatokelas')->find($id);
        if (!$Siswa) {
            return ['status' => 'error', 'message' => '❌ Data siswa tidak ditemukan'];
        }

        $DataSiswa = Eabsen::where('detailsiswa_id', $id)
            ->where('tapel_id', $Tapels->id)
            ->whereDate('created_at', Carbon::today()) // <-- hanya record hari ini
            ->with('EabsentoDetailsiswa')
            ->first();

        $Kami = $faker->randomElement(['Kami', 'Sekolah']);
        $Ucapkan = $faker->randomElement(['ucapkan', 'haturkan', 'sampaikan']);
        $Menyampaikan = $faker->randomElement(['menyampaikan', 'informasikan', 'beritahukan']);
        $Disiplin = $faker->randomElement(['disiplin waktu', 'disiplin', 'tepat waktu']);

        $nama = $Siswa->nama_siswa ?? '*Tidak Terisi*';
        $kelas = optional($Siswa->Detailsiswatokelas)->kelas ?? '-';
        $tanggal = Carbon::now()->translatedFormat('l, d F Y');
        $jam = $DataSiswa && $DataSiswa->created_at
            ? Carbon::parse($DataSiswa->created_at)->translatedFormat('H:i:s')
            : Carbon::now()->translatedFormat('H:i:s');


        // Tangani jika tidak ada absen sama sekali
        if (!$DataSiswa) {
            return "📌 *LAPORAN ABSENSI*\n\n" .
                "Selamat Pagi Bp / Ibu, mohon maaf.\n" .
                "Belum terdapat data absensi untuk ananda *$nama* pada tahun pelajaran aktif.\n\n" .
                "✍️ Dikirim oleh:\nWhatsappBot Sekolah";
        }

        $jamSekarang = Carbon::now()->format('H');
        $sapaan = $jamSekarang >= 10 ? 'Selamat Siang' : 'Selamat Pagi';

        $isi =
            "$sapaan Bp / Ibu, $Kami $Menyampaikan terkait dengan absensi kehadiran ananda {$nama} sebagai berikut : \n\n" .
            "📝 Nama\t\t: {$nama}\n" .
            "🏫 Kelas\t\t: {$kelas}\n" .
            "📅 Tanggal\t: {$tanggal}\n" .
            "⏰ Jam\t\t\t: {$jam}\n" .
            "\n" . str_repeat("─", 25) . "\n" .
            "$Kami $Ucapkan banyak terima kasih atas partisipasi Bp / Ibu dalam mengarahkan ananda $nama agar selalu $Disiplin\n\n\n";
        $message = format_pesan('LAPORAN ABSENSI HARI INI', $isi);
        return $message;
    }
}
// Absensi dalam 1 Bulan
// Absensi Bulanan jika bulan null brrt bulan sekarang
if (!function_exists('PesanAbsensiBulananOrtu')) {
    function PesanAbsensiBulananOrtu($id, $bulan = null)
    {
        $now   = \Carbon\Carbon::now();
        $bulan = $bulan ?? $now->month;                   // untuk query 9
        $tahun     = $now->year;                    // untuk query 2025
        $namaBulan = $now->translatedFormat('F');   // untuk tampilan

        $Siswa = \App\Models\User\Siswa\Detailsiswa::with('KelasOne')->find($id);

        if (!$Siswa) {
            return "❌ Data siswa tidak ditemukan.";
        }

        $query = \App\Models\Absensi\Eabsen::where('detailsiswa_id', $Siswa->id)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun);
        $rekap = [
            'masuk'  => [
                'hadir' => (clone $query)->where('jenis_absen', 'masuk')->where('absen', 'hadir')->count(),
                'sakit' => (clone $query)->where('jenis_absen', 'masuk')->where('absen', 'sakit')->count(),
                'ijin'  => (clone $query)->where('jenis_absen', 'masuk')->whereIn('absen', ['ijin', 'izin'])->count(),
                'alfa'  => (clone $query)->where('jenis_absen', 'masuk')->whereIn('absen', ['alfa', 'alpa', 'alpha'])->count(),
                'bolos' => (clone $query)->where('jenis_absen', 'masuk')->where('absen', 'bolos')->count(),
            ],
            'pulang' => [
                'hadir' => (clone $query)->where('jenis_absen', 'pulang')->where('absen', 'hadir')->count(),
                'sakit' => (clone $query)->where('jenis_absen', 'pulang')->where('absen', 'sakit')->count(),
                'ijin'  => (clone $query)->where('jenis_absen', 'pulang')->whereIn('absen', ['ijin', 'izin'])->count(),
                'alfa'  => (clone $query)->where('jenis_absen', 'pulang')->whereIn('absen', ['alfa', 'alpa', 'alpha'])->count(),
                'bolos' => (clone $query)->where('jenis_absen', 'pulang')->where('absen', 'bolos')->count(),
            ],
        ];

        $masuk  = $rekap['masuk'];
        $pulang = $rekap['pulang'];
        $isi =
            "📊 Rekap Absensi Bulan *{$namaBulan} {$tahun}*\n" .
            "👦 Ananda : *{$Siswa->nama_siswa}*\n" .
            "🏫 Kelas  : *" . optional($Siswa->KelasOne)->kelas . "*\n\n" .
            "➡️ *Masuk:*\n" .
            "   ✅ Hadir \t\t\t: {$masuk['hadir']}\n" .
            "   🤒 Sakit \t\t\t: {$masuk['sakit']}\n" .
            "   📝 Ijin  \t\t\t\t: {$masuk['ijin']}\n" .
            "   ❌ Alfa  \t\t\t\t: {$masuk['alfa']}\n" .
            "   🚶 Bolos \t\t\t: {$masuk['bolos']}\n\n" .
            "➡️ *Pulang:*\n" .
            "   ✅ Hadir \t\t\t: {$pulang['hadir']}\n" .
            "   🤒 Sakit \t\t\t: {$pulang['sakit']}\n" .
            "   📝 Ijin  \t\t\t\t: {$pulang['ijin']}\n" .
            "   ❌ Alfa  \t\t\t\t: {$pulang['alfa']}\n" .
            "   🚶 Bolos \t\t\t: {$pulang['bolos']}\n" .
            "" . str_repeat("─", 25) . "\n" .
            "🙏 Kami sampaikan terima kasih atas perhatian dan kerjasamanya.\n" .
            "Semoga ananda *{$Siswa->nama_siswa}* semakin semangat dan disiplin.\n\n";

        $message = format_pesan('LAPORAN ABSENSI BULANAN', $isi);
        return $message;
    }
}

// Absensi dalam 1 tahun
if (!function_exists('PesanAbsensiTahunan')) {
    function PesanAbsensiTahunan($id)
    {
        //Isi Fungsi
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $faker = Faker::create();

        $Siswa = Detailsiswa::with('Detailsiswatokelas')->find($id);
        if (!$Siswa) {
            return ['status' => 'error', 'message' => '❌ Data siswa tidak ditemukan'];
        }

        $DataSiswa = Eabsen::where('detailsiswa_id', $id)
            ->where('tapel_id', $Tapels->id)
            ->with('EabsentoDetailsiswa')
            ->get();

        $Kami = $faker->randomElement(['Kami', 'Sekolah']);
        $Ucapkan = $faker->randomElement(['ucapkan', 'haturkan', 'sampaikan']);
        $Menyampaikan = $faker->randomElement(['menyampaikan', 'informasikan', 'beritahukan']);
        $Disiplin = $faker->randomElement(['disiplin waktu', 'disiplin', 'tepat waktu']);

        $nama = $Siswa->nama_siswa ?? '*Tidak Terisi*';
        $kelas = optional($Siswa->Detailsiswatokelas)->kelas ?? '-';
        $tanggal = Carbon::now()->translatedformat('l, d F Y');
        $jam = Carbon::now()->translatedFormat('H:i:s'); // Bukan dari created_at siswa, itu aneh

        // Tangani jika tidak ada absen sama sekali
        if ($DataSiswa->isEmpty()) {
            return "📌 *LAPORAN ABSENSI*\n\n" .
                "Selamat Pagi Bp / Ibu, mohon maaf.\n" .
                "Belum terdapat data absensi untuk ananda *$nama* pada tahun pelajaran aktif.\n\n" .
                "✍️ Dikirim oleh:\nWhatsappBot Sekolah";
        }


        // Jangan return di sini! return $DataSiswa; <- HAPUS!

        $Grouped = $DataSiswa->groupBy(function ($item) {
            return Carbon::parse($item->waktu_absen)->format('Y-m');
        });

        $RekapBulanan = $Grouped->map(function ($items, $bulan) {
            $sakit = $items->filter(fn($i) => strtolower($i->absen) === 'sakit')->count();
            $ijin  = $items->filter(fn($i) => in_array(strtolower($i->absen), ['izin', 'ijin']))->count();
            $alpa  = $items->filter(fn($i) => in_array(strtolower($i->absen), ['alfa', 'alpa', 'alpha']))->count();
            $hadir = $items->filter(fn($i) => strtolower($i->absen) === 'hadir')->count();

            return [
                'bulan'  => $bulan,
                'sakit'  => $sakit,
                'ijin'   => $ijin,
                'alpa'   => $alpa,
                'hadir'  => $hadir,
                'jumlah_total' => $sakit + $ijin + $alpa + $hadir,
            ];
        })->values();

        $rekapText = "📆 Rekapitulasi Bulanan:\n\n";
        foreach ($RekapBulanan as $rekap) {
            $rekapText .= "🗓️ Bulan: " . Carbon::createFromFormat('Y-m', $rekap['bulan'])->translatedFormat('F Y') . "\n";
            $rekapText .= "   ✅ Hadir : " . $rekap['hadir'] . "\n";
            $rekapText .= "   🤒 Sakit : " . $rekap['sakit'] . "\n";
            $rekapText .= "   📝 Izin  : " . $rekap['ijin'] . "\n";
            $rekapText .= "   ❌ Alpa  : " . $rekap['alpa'] . "\n";
            $rekapText .= "   📊 Total : " . $rekap['jumlah_total'] . "\n";
            $rekapText .= str_repeat("─", 25) . "\n";
        }
        $jamSekarang = Carbon::now()->format('H');
        $sapaan = $jamSekarang >= 10 ? 'Selamat Siang' : 'Selamat Pagi';

        $isi =
            "$sapaan Bp / Ibu, $Kami $Menyampaikan terkait dengan absensi kehadiran ananda $nama sebagai berikut : \n\n" .
            "📝 Nama\t\t: $nama\n" .
            "🏫 Kelas\t\t: $kelas\n" .
            "$rekapText" .
            "$Kami $Ucapkan banyak terima kasih atas partisipasi Bp / Ibu dalam mengarahkan ananda $nama agar selalu $Disiplin\n";
        $message = format_pesan('LAPORAN ABSENSI 1 SEMESTER', $isi);
        return $message;
    }
}
if (!function_exists('ExportAbsensiGuru')) {
    function ExportAbsensiGuru($kode)
    {
        //Isi Fungsi
    }
}
if (!function_exists('rekap_absensi_kelas')) {
    function rekap_absensi_kelas($kelas_id)
    {
        $tapel = tapel();
        $tahun = $tapel['tapel'];
        $semester = $tapel['semester'];

        $bulanArray = $semester === 'I'
            ? [7, 8, 9, 10, 11, 12]  // Semester 1
            : [1, 2, 3, 4, 5, 6];    // Semester 2

        // Ambil semua siswa di kelas tsb
        $siswa_ids = Detailsiswa::where('kelas_id', $kelas_id)->pluck('id');

        // Ambil semua data absensi & olah
        $datas = Eabsen::whereYear('waktu_absen', $tahun)
            ->whereIn('detailsiswa_id', $siswa_ids)
            ->get()
            ->groupBy('detailsiswa_id')
            ->map(function ($absen) use ($tahun, $bulanArray) {
                $data = ['detailsiswa_id' => $absen->first()->detailsiswa_id];
                foreach ($bulanArray as $bulan) {
                    $firstDay = Carbon::create($tahun, $bulan, 1)->startOfMonth();
                    $lastDay = Carbon::create($tahun, $bulan, 1)->endOfMonth();
                    $bulanName = Carbon::parse($firstDay)->format('M');

                    $data['H_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])
                        ->where('absen', 'hadir')->count();
                    $data['S_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])
                        ->where('absen', 'sakit')->count();
                    $data['I_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])
                        ->where('absen', 'ijin')->count();
                    $data['A_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])
                        ->where('absen', 'alfa')->count();
                }
                return $data;
            })
            ->sortBy(function ($item) {
                return optional(Detailsiswa::find($item['detailsiswa_id']))->nama_siswa;
            })
            ->values();

        return [
            'tahun' => $tahun,
            'semester' => $semester,
            'bulanArray' => $bulanArray,
            'datas' => $datas
        ];
    }
}
if (!function_exists('ExportAbsensiKelas')) {
    function ExportAbsensiKelas($kelas_id, $NoRequest)
    {
        $tapel = tapel();
        $tahun = $tapel['tapel'];
        $semester = $tapel['semester'];

        $bulanArray = $semester === 'I'
            ? [7, 8, 9, 10, 11, 12]
            : [1, 2, 3, 4, 5, 6];

        // 🔍 Ambil semua siswa di kelas
        $siswa_ids = Detailsiswa::where('kelas_id', $kelas_id)->pluck('id');

        // 🔍 Ambil data absensi mereka
        $datas = Eabsen::whereYear('waktu_absen', $tahun)
            ->whereIn('detailsiswa_id', $siswa_ids)
            ->get()
            ->groupBy('detailsiswa_id')
            ->map(function ($absen) use ($tahun, $bulanArray) {
                $data = ['detailsiswa_id' => $absen->first()->detailsiswa_id];
                foreach ($bulanArray as $bulan) {
                    $firstDay = Carbon::create($tahun, $bulan, 1)->startOfMonth();
                    $lastDay = Carbon::create($tahun, $bulan, 1)->endOfMonth();
                    $bulanName = Carbon::parse($firstDay)->format('M');
                    $data['H_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])->where('absen', 'hadir')->count();
                    $data['S_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])->where('absen', 'sakit')->count();
                    $data['I_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])->where('absen', 'ijin')->count();
                    $data['A_' . $bulanName] = $absen->whereBetween('waktu_absen', [$firstDay, $lastDay])->where('absen', 'alfa')->count();
                }
                return $data;
            })
            ->sortBy(function ($item) {
                return optional(Detailsiswa::find($item['detailsiswa_id']))->nama_siswa;
            })
            ->values();

        // 🔹 Data identitas sekolah
        $dataIdentitas = DataIdentitas();

        // 🔹 Data untuk laporan
        $data = array_merge([
            'judul' => 'Rekapitulasi Absensi Siswa',
            'subjudul' => 'Kelas ID: ' . $kelas_id,
            'tahun' => $tahun,
            'semester' => $semester,
            'tanggal_cetak' => now()->translatedFormat('d F Y'),
            'datas' => $datas,
            'bulanArray' => $bulanArray,
            'logo'           => 'img/logo.png',
            'arr_ths' => ['NIS', 'Nama']
        ], $dataIdentitas);

        // 🔹 Path & nama file
        $folder = public_path('temp/export/absensi');
        $kelas_nama = optional(Ekelas::find($kelas_id))->kelas ?? 'Tanpa Nama';
        $filename = 'Rekap Absensi Kelas ' . $kelas_nama . ' - Semester ' . $semester;
        $view = 'role.walkes.export-pdf-rekap-absensi';

        // 🔹 Render PDF
        DomExport($filename, $data, $view, $folder);

        // 🔹 (Opsional) kirim ke WA
        CopyFileWa($filename . '.pdf', 'temp/export/absensi');

        return $filename . '.pdf';
    }
}
// Absensi Guru
use Illuminate\Support\Facades\Response;

if (!function_exists('absen_guru')) {
    function absen_guru($kode_guru, $message)
    {
        // Absen Now/Kepala/AS/hadir:sakit:ijin/Keterangan
        $pesan = explode('/', $message);
        $guru = Detailguru::where('kode_guru', $kode_guru)->first();

        $tapel = tapel();
        //$tapel->id
        //where('tapel_id', $tapel->id)->
        if (!$guru) {
            return Response::json([
                'success' => false,
                'message' => '❌ Kode Guru tidak ditemukan',
            ]);
        }

        $jamSekarang = now();
        $jamBatasMasuk = Carbon::today()->setTimeFromTimeString('07:05');

        // Tentukan jam pulang sesuai hari
        if (is_day('sabtu')) {
            $jamBatasPulang = Carbon::today()->setTimeFromTimeString('11:00');
        } elseif (is_day("jum'at")) {
            $jamBatasPulang = Carbon::today()->setTimeFromTimeString('11:00');
        } elseif (is_day("senin")) {
            $jamBatasPulang = Carbon::today()->setTimeFromTimeString('11:00');
        } else {
            $jamBatasPulang = Carbon::today()->setTimeFromTimeString('11:00');
        }

        // ==========================
        // 1. Cek riwayat absen hari ini
        // ==========================
        $absenMasuk = \App\Models\Absensi\EabsenGuru::whereDate('created_at', today())
            ->where('detailguru_id', $guru->id)
            ->where('jenis_absen', 'masuk')
            ->first();

        $absenPulang = \App\Models\Absensi\EabsenGuru::whereDate('created_at', today())
            ->where('detailguru_id', $guru->id)
            ->where('jenis_absen', 'pulang')
            ->first();

        // ==========================
        // 2. Tentukan jenis absen + cek interval minimal untuk pulang
        // ==========================
        if (!$absenMasuk) {
            $jenisAbsen = 'masuk';
        } elseif (!$absenPulang) {
            $diff = $absenMasuk->created_at->diffInMinutes($jamSekarang);

            if ($diff < 240) { // minimal 4 jam
                return Response::json([
                    'error' => true,
                    'message' => "⚠️ Belum waktunya pulang, tunggu minimal 4 jam sejak absen masuk!",
                ]);
            }

            $jenisAbsen = 'pulang';
        } else {
            return Response::json([
                'error' => false,
                'message' => "⚠️ Sudah absen hari ini!",
            ]);
        }

        // ==========================
        // 3. Hitung telat / pulang cepat / pulang telat
        // ==========================
        $telatMenit = 0;
        $pulangCepat = 0;
        $pulangTelat = 0;

        if ($jenisAbsen === 'masuk') {
            if ($jamSekarang->greaterThan($jamBatasMasuk)) {
                $telatMenit = $jamBatasMasuk->diffInMinutes($jamSekarang);
            }
        } else {
            if ($jamSekarang->lessThan($jamBatasPulang)) {
                $pulangCepat = $jamBatasPulang->diffInMinutes($jamSekarang);
            } elseif ($jamSekarang->greaterThan($jamBatasPulang)) {
                $pulangTelat = $jamSekarang->diffInMinutes($jamBatasPulang);
            }
        }

        // ==========================
        // 4. Simpan ke database
        // ==========================
        $kehadiran = $pesan[3] ?? 'hadir';
        $keterangan = $pesan[4] ?? null;

        $absen = \App\Models\Absensi\EabsenGuru::create([
            'detailguru_id' => $guru->id,
            'tapel_id'      => $tapel->id ?? null,
            'semester'      => $tapel->semester ?? null,
            'absen'         => $kehadiran,
            'jenis_absen'   => $jenisAbsen,
            'keterangan'   => $keterangan,
            'waktu_absen'   => $jamSekarang,
            'telat'         => $telatMenit,
            'pulang_cepat'  => $pulangCepat,
            'pulang_telat'  => $pulangTelat,
        ]);

        // ==========================
        // 5. Kirim WA (optional)
        // ==========================
        $gelar = $guru->gelar ?? '';
        if (strtolower($kehadiran) === 'sakit') {
            $pesanKeterangan =
                "Gunakan waktu Bapak/Ibu *{$guru->nama_guru}, {$gelar}* untuk istirahat sebaik mungkin\n" .
                "Semoga Bapak/Ibu *{$guru->nama_guru}, {$gelar}* segera diberikan kesembuhan, dan dapat segera melaksanakan tugas kembali\n" .
                "Amiin\n";
        } elseif (strtolower($kehadiran) === 'ijin') {
            $pesanKeterangan =
                "Semoga waktu ijinnya dapat digunakan sebaik mungkin, dan segala urusan yang akan dikerjakan bisa segera terselesaikan dengan mudah sehingga dala segera kembali melaksanakan tugas disekolah\n" .
                "Amiin\n";
        } else {
            $pesanKeterangan =
                "✨ Semoga hari ini berjalan lancar dan tugas bisa dilaksanakan maksimal.\n" .
                "🙏 Terima kasih atas partisipasi dalam kegiatan KBM.\n";
        }
        if ($guru->no_hp) {
            $waktuabsen = $jenisAbsen === 'masuk' ? 'Pagi' : 'Siang';
            $IsiPesan =
                "🌞 Selamat {$waktuabsen} Bapak/Ibu *{$guru->nama_guru}, {$gelar}*\n" .
                "📋 Berikut rekap data yang masuk:\n" .
                "⏰ Waktu Absen : {$jamSekarang->format('H:i')} WIB\n" .
                "⏰ Telat        : {$telatMenit} menit\n" .
                "🟢 Kehadiran   : {$kehadiran}\n" .
                "💬 Keterangan  : {$keterangan}\n\n" .
                "{$pesanKeterangan}\n\n";


            $PesanKirim = format_pesan('Informasi Kehadiran Guru', $IsiPesan);
            $NoTujuan = config('whatsappSession.WhatsappDev')
                ? config('whatsappSession.DevNomorTujuan')
                : $guru->no_hp;

            $sessions = config('whatsappSession.IdWaUtama');
            \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $PesanKirim);
        }

        // ==========================
        // 6. Hapus cache (jika ada)
        // ==========================
        if (function_exists('HapusCacheDenganTag')) {
            HapusCacheDenganTag('chace_AbsensiHaraIni');
            HapusCacheDenganTag('chacprosesabsen');
        }

        // ==========================
        // 7. Return hasil
        // ==========================
        return Response::json([
            'success' => true,
            'message' => "✅ Absen $jenisAbsen berhasil!",
            'data' => [
                'kode_guru' => $guru->kode_guru,
                'nama_guru' => $guru->nama_guru,
                'waktu' => $absen->waktu_absen->format('H:i:s'),
                'jenis' => $jenisAbsen,
                'telat' => $telatMenit ? "$telatMenit menit" : 'Tepat waktu',
                'pulang_cepat' => $pulangCepat ? "$pulangCepat menit" : null,
                'pulang_telat' => $pulangTelat ? "$pulangTelat menit" : null,
            ],
        ]);
    }
}
