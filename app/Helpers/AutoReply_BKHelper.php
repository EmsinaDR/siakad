<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Admin\Etapel;
use App\Models\bk\Bkbimbingan;
use App\Models\Admin\Identitas;
use App\Models\bk\Ebkkreditpoint;
use App\Models\bk\Ebkpelanggaran;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\Log;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 AutoReply_BKHelper :
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
if (!function_exists('Auto_reply_BK')) {
    function Auto_reply_BK($Kode, $Siswa, $NoRequest, $message)
    {
        $Identitas = Identitas::first();
        $data = explode('/', $message);
        $sessions = config('whatsappSession.IdWaUtama');
        switch ($Kode) {
            case 'Bimbingan': //Bimbingan/BK/Kode Guru/NIS/Masalah ( Pendaftaran bimbingan digital)
                $kodeguru = $data[2];
                $nis = $data[3];
                $Guru = Detailguru::where('kode_guru', $kodeguru)->first();
                $Siswa = Detailsiswa::where('nis', $nis)->first();
                $tapel = Etapel::where('aktiv', 'Y')->first();

                $DataPesan = explode('/', $message);
                $Data2 = $DataPesan[2] ?? ''; // Guru
                $Data3 = $DataPesan[3] ?? ''; // NIS
                $Data4 = $DataPesan[4] ?? ''; // Persmasalahan
                if (count($DataPesan) < 4) {
                    return 'Pesan tidak valid atau format kurang lengkap.';
                }
                $Guru = Detailguru::where('kode_guru', $DataPesan[2])->first();
                $Siswaz = Detailsiswa::where('nis', $Data3)->first();
                if (!$Siswaz) {
                    return 'Siswa Tidak Ditemukan';
                }

                $tanggal = now();
                $data = [
                    'tapel_id' => $tapel->id,
                    'detailsiswa_id' => $Siswaz->id,
                    'detailguru_id' => $Guru->id,
                    'permasalahan' => $Data4,
                    'tanggal' => $tanggal,
                    'proses' => 'Pending',
                ];

                // Simpan jika diperlukan
                Bkbimbingan::create($data);
                HapusCacheDenganTag('dataBimbingan');
                if ($Guru->jenis_kelamin === 'Laki-laki') {
                    $sapaan = 'Bapak';
                } else {
                    $sapaan = 'Ibu';
                }
                $pesanKiriman = "Hallo *{$Siswaz->nama_siswa}* pesan sudah diterima, mohon tunggu konfirmasi lebih lanjut dari {$sapaan} *{$Guru->nama_guru},{$Guru->gelar}*";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  $pesanKiriman);
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  DataKode($Guru->id));
                break;
            case 'Kredit Point':
                //Data Point/BK/NIS
                $totalPelanggaran = Ebkpelanggaran::with('EbkPelanggaranEkreditpoint')
                    ->where('pelaku_id', $Siswa->id)
                    ->get();

                $totalPoint = $totalPelanggaran->sum('point');

                // Ambil semua nama pelanggaran dari relasi
                $pelanggaranList = $totalPelanggaran->map(function ($item) {
                    return $item->EbkPelanggaranEkreditpoint?->pelanggaran;
                })->filter()->values()->all(); // ->all() mengubah Collection jadi array biasa

                $pelanggaranText = $totalPelanggaran
                    ->pluck('EbkPelanggaranEkreditpoint.pelanggaran')
                    ->filter()
                    ->values()
                    ->map(fn($item, $index) => ($index + 1) . ". " . $item) // nomor otomatis
                    ->implode("\n");


                $IsiPesan =
                    "Kami informasikan bahwa *ananda {$Siswa->nama_siswa}* saat ini mendapat kredit point sebagai berikut :\n" .
                    "Jumlah Point : " . $totalPoint . "\n" .
                    "Jumlah Pelanggaran : " . $totalPelanggaran->count() . "\n\n" .
                    "Rincian Pelanggaran :\n" . $pelanggaranText . "\n\n";

                $pesanKiriman = format_pesan('Informasi Kredit Point', $IsiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Data Kredit Point':
                //Data Kredit Point/BK/NIS
                $DataKreditPoint = Ebkkreditpoint::all(); // ambil semua data
                $IsiPesan = "Kami informasikan data kredit point saat ini yang berlaku :\n\n";

                foreach ($DataKreditPoint as $index => $data) {
                    $IsiPesan .= ($index + 1) . ". Kategori : " . $data->kategori . "\n";
                    $IsiPesan .= "   Point : " . $data->point . "\n";
                    $IsiPesan .= "   Pelanggaran : " . $data->pelanggaran . "\n";
                    $IsiPesan .= str_repeat("─", 25) . "\n"; // garis pemisah
                }

                $pesanKiriman = format_pesan('Informasi Kredit Point', $IsiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            case 'Ijin Keluar':
                // Ijin Keluar/BK/NIS/tempat tujuan/durasi/keterangan
                // Ijin Keluar/BK/NIS/SD/2 Jam/ Cap 3 Jari di SD

                $IsiPesan = "Kami informasikan data kredit point saat ini yang berlaku :\n\n";

                $pesanKiriman = format_pesan('Informasi Kredit Point', $IsiPesan);
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;


            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
