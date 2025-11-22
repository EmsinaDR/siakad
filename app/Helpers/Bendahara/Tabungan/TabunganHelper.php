<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper TabunganHelper
    |----------------------------------------------------------------------
    |
*/

use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Admin\Etapel;
use Illuminate\Support\Number;
use App\Models\Admin\Identitas;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Bendahara\BendaharaTabungan;

if (!function_exists('RekapTabungan')) {
    function RekapTabungan($id)
    {
        $tabungan = BendaharaTabungan::where('detailsiswa_id', $id)->get();
        $pemasukan = $tabungan->where('type', 'pemasukkan')->sum('nominal');
        $pengeluaran = $tabungan->where('type', 'pengeluaran')->sum('nominal');
        $data = [
            'pemasukkan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo' => $pemasukan - $pengeluaran,
        ];
        // return $tabungan;
        return $data;
    }
}
if (!function_exists('RekapTabunganBulanan')) {
    function RekapTabunganBulanan($id)
    {
        $tabungan = BendaharaTabungan::where('detailsiswa_id', $id)->get();

        $rekap = $tabungan->groupBy(function ($item) {
            return $item->created_at->format('Y-m'); // contoh: 2025-08
        })->map(function ($items) {
            $pemasukan = $items->where('type', 'pemasukkan')->sum('nominal');
            $pengeluaran = $items->where('type', 'pengeluaran')->sum('nominal');
            return [
                'pemasukkan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $pemasukan - $pengeluaran,
            ];
        });

        return $rekap;
    }
}
if (!function_exists('WaRekapTabunganBulanan')) {
    function WaRekapTabunganBulanan($id)
    {
        $tabungan = BendaharaTabungan::with('siswa')->where('detailsiswa_id', $id)->get();

        if ($tabungan->isEmpty()) {
            return "⚠️ Tidak ada data tabungan untuk siswa ini.";
        }

        $rekap = $tabungan->groupBy(function ($item) {
            return $item->created_at->format('Y-m'); // contoh: 2025-08
        })->map(function ($items) {
            $pemasukan = $items->where('type', 'pemasukkan')->sum('nominal');
            $pengeluaran = $items->where('type', 'pengeluaran')->sum('nominal');
            return [
                'pemasukkan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $pemasukan - $pengeluaran,
            ];
        });

        $rekapString = []; // inisialisasi biar aman

        foreach ($rekap as $bulan => $data) {
            $formattedBulan = \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y');
            $formattedPemasukan = 'Rp ' . number_format($data['pemasukkan'], 0, ',', '.');
            $formattedPengeluaran = 'Rp ' . number_format($data['pengeluaran'], 0, ',', '.');
            $formattedSaldo = 'Rp ' . number_format($data['saldo'], 0, ',', '.');

            $rekapString[] =
                "📅 *{$formattedBulan}*\n" .
                "   ➕ Pemasukan: {$formattedPemasukan}\n" .
                "   ➖ Pengeluaran: {$formattedPengeluaran}\n" .
                "   💰 Saldo: {$formattedSaldo}\n";
        }
        // gabung jadi string pesan WhatsApp
        $pesan =
            "Diberitahukan informasi Rekap Tabungan Bulanan, ananda *{$tabungan->first()->siswa->nama_siswa}*:\n\n" .
            "" . implode("\n", $rekapString) .
            "Terima kasih.\n" .
            "Semoga ananda *{$tabungan->first()->siswa->nama_siswa}* terbiasa menabung dan mengelola keuangan dengan baik. 😊\n";
        $message = format_pesan("Rekap Tabungan Bulanan", $pesan);


        return $message;
    }
}
if (!function_exists('tabungan_siswa')) {
    function tabungan_siswa($id)
    {
        //Isi Fungsi
        $Identitas = Identitas::first();
        $etapels = Etapel::where('aktiv', 'Y')->first();
        //$etapels->id
        //where('tapel_id', )->
        $faker = Faker::create(); //Simpan didalam code run
        $Siswa = Detailsiswa::with('Detailsiswatokelas')->find($id);
        $jamSekarang = Carbon::now()->format('H');
        $sapaan = $jamSekarang >= 10 ? 'Selamat Siang' : 'Selamat Pagi';
        if (!$Siswa) {
            return 'Data tidak ditemukan';
        }
        $DataTabunganAll = BendaharaTabungan::where('detailsiswa_id', $id)->get();
        $Pemasukkan = $DataTabunganAll->where('tapel_id', $etapels->id)->where('type', 'pemasukkan')->sum('nominal');
        $RpPemasukan = Number::format($Pemasukkan, precision: 2);
        $Pengeluaran = $DataTabunganAll->where('tapel_id', $etapels->id)->where('type', 'pengeluaran')->sum('nominal');
        $RpPengeluaran = Number::format($Pengeluaran, precision: 2);
        $Sisa = $Pemasukkan - $Pengeluaran;
        $Rpsisa = Number::format($Sisa, precision: 2);
        $pesanKiriman =
            "Kami sampaikan data tabungan atas nama *Ananda {$Siswa->nama_siswa}* pada periode ini *Semester {$etapels->semester} Tapel {$etapels->tapel}*:\n" .
            "💵 Pemasukan\t\t: Rp. {$RpPemasukan}\n" .
            "🛒 Pengeluaran\t\t: Rp. {$RpPengeluaran}\n" .
            "🏦 Sisa\t\t\t\t\t\t\t: Rp. {$Rpsisa}\n\n";

        // Cek kalau tidak ada pemasukan sama sekali
        if ($Pemasukkan <= 0) {
            $pesanKiriman .=
                "📌 *Mohon perhatian*\n" .
                "Pada periode ini *Ananda {$Siswa->nama_siswa}* belum memiliki aktivitas menabung.\n" .
                "Mari kita dorong bersama agar *Ananda* mulai menyisihkan sebagian uang sakunya " .
                "untuk menumbuhkan kebiasaan positif sejak dini dalam kedisiplinan dan perencanaan pengelolaan uang.\n";
        } else {
            $persentaseTarget = 0.20; // 20%
            $targetMinimal = $Pemasukkan * $persentaseTarget;
            $persentaseTercapai = ($Sisa / $Pemasukkan) * 100;

            if ($Sisa >= $targetMinimal) {
                $pesanKiriman .=
                    "👏 Luar biasa! *Ananda {$Siswa->nama_siswa}* berhasil menyisihkan sekitar " .
                    round($persentaseTercapai, 1) . "% dari pemasukan untuk tabungan.\n" .
                    "Semoga kebiasaan baik ini terus terjaga dan menjadi bekal positif di masa depan.\n";
            } else {
                $pesanKiriman .=
                    "Mari kita terus membimbing *Ananda {$Siswa->nama_siswa}* agar membiasakan menabung. " .
                    "Target minimal " . ($persentaseTarget * 100) . "% dari pemasukan akan sangat bermanfaat " .
                    "untuk melatih kedisiplinan dan perencanaan keuangan sejak dini.\n";
            }
        }
        $Pesan = format_pesan("Informasi Tabungaan", $pesanKiriman);
        return $Pesan . "\n\n";
    }
}
