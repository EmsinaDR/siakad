<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use Carbon\CarbonPeriod;
use App\Models\Admin\Identitas;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 PembayaranHelper :
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
if (!function_exists('PesanPembayaran')) {
    function PesanPembayaran($id)
    {
        $Identitas = Identitas::first();
        $faker = Faker::create(); //Simpan didalam code run
        $Siswa = Detailsiswa::with('Detailsiswatokelas')->find($id);
        $jamSekarang = Carbon::now()->format('H');
        $sapaan = $jamSekarang >= 10 ? 'Selamat Siang' : 'Selamat Pagi';
        if (!$Siswa) {
            return ['status' => 'error', 'message' => '❌ Data siswa tidak ditemukan'];
        }
        $RekapPembayaran = 'xxxx';

        $Kami = $faker->randomElement(['Kami', 'Sekolah']);
        $Ucapkan = $faker->randomElement(['ucapkan', 'haturkan', 'sampaikan']);
        $Menyampaikan = $faker->randomElement(['menyampaikan', 'informasikan', 'beritahukan']);
        $Disiplin = $faker->randomElement(['disiplin waktu', 'disiplin', 'tepat waktu']);
        $nama = $Siswa->nama_siswa;
        $kelas = optional($Siswa->Detailsiswatokelas)->kelas ?? '-';
        $tanggal = Carbon::now()->translatedformat('l, d F Y');
        $jam = $Siswa->created_at->translatedFormat('H:i:s');
        $bulan = Carbon::create(now())->translatedformat('F');
        // Sumber Database
        $IsiPembaayranSiswa =
            "*Pembayaran Daftar Ulang:*\n" .
            "💰 Kewajiban : Rp. 25.000\n" .
            "✅ Terbayar : Rp. 15.000\n" .
            "⚠️ Kekurangan : *Rp. 10.000*\n\n" .

            "*Pembayaran Ekstra:*\n" .
            "💰 Kewajiban : Rp. 25.000\n" .
            "✅ Terbayar : Rp. 15.000\n" .
            "⚠️ Kekurangan : *Rp. 10.000*\n\n" .

            "*Pembayaran Seragam:*\n" .
            "💰 Kewajiban : Rp. 25.000\n" .
            "✅ Terbayar : Rp. 15.000\n" .
            "⚠️ Kekurangan : *Rp. 10.000*\n\n" .
            "";
        if ($Identitas->paket !== 'Peremium') {
            $isiPesan =
                "*Assalamu'alaikum Wr.Wb.*\n" .
                "Yth. Bapak / Ibu Wali Murid dari *{$Siswa->nama_siswa}*, dimohon dengan hormat untuk segera melakukan kewajiban pembayaran pada *bulan {$bulan}*, demi kelancaran kegiatan - kegiatan putra / putri disekolah paling lambat tanggal 10.\n\n" .
                "Atas segala perhatian dan kerjasamanya kami sampaikan banyak terima kasih.\n\n" .
                "*Wassalamu'alaikum Wr.Wb.*\n";
        } else {
            $isiPesan =
                "*Assalamu'alaikum Wr.Wb.*\n" .
                "$sapaan Bapak / Ibu Wali Murid dari Ananda *{$Siswa->nama_siswa}*, $Kami $Menyampaikan terkait dengan pembayaran keuangan ananda *{$nama}* sebagai berikut : \n\n" .
                $IsiPembaayranSiswa .
                "Kepada Bapak / Ibu dimohon dengan hormat melalukan kewajiban pembayaran pada *bulan {$bulan}* paling lambat tanggal 10.\n" .
                "$Kami $Ucapkan banyak terima kasih atas segala kepercayaan Bapak / Ibu kepada kami\n" .
                "*Wassalamu'alaikum Wr.Wb.*\n";
        }
        $message =
            "================================\n" .
            "📌 *INFORMASI PEMBAYARAN*\n" .
            "================================\n\n" .
            $isiPesan .
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirim oleh:\n" .
            "*Boot Assistant Pelayanan {$Identitas->namasek}*";
        return $message;
    }
}
