<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Admin\Etapel;
use App\Models\Absensi\Eabsen;
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
