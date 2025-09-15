<?php

use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use Carbon\CarbonPeriod;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Admin\Identitas;
use Illuminate\Support\Facades\Log;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 AutoReply_CariHelper :
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
if (!function_exists('Auto_reply_CariKode')) {
    function Auto_reply_CariKode($Kode, $Siswa, $NoRequest, $message)
    {
        $Identitas = Identitas::first();
        $data = explode('/', $message);
        $sessions = config('whatsappSession.IdWaUtama');
        switch ($Kode) {
            // $data = explode('/', $message);
            case 'Siswa': //Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
                // handling cek guru
                // Siswa/Cari/key/pencarian
                // Siswa/Cari/kelas/VII A
                // Siswa/Cari/nama/xxxx
                // Siswa/Cari/alamat/xxxx
                // Siswa/Cari/nis/2025xx
                // Siswa/Cari/statusytm/yatim:piatu:yatim piatu:lengkap
                // Cari/Siswa
                $field = $data['2'];
                if ($data[2] === 'kelas') {
                    $etapels = Etapel::where('aktiv', 'Y')->first();
                    $kelasId = Ekelas::where('tapel_id', $etapels->id)->where('kelas', $data[3])->first();
                    $keyword = $kelasId->id;
                } else {
                    $keyword = $data[3] ?? '';
                }
                $fieldMap = [
                    'nama' => 'nama_siswa',
                    'nis' => 'nis',
                    'alamat' => 'alamat_siswa',
                    'kelas' => 'kelas_id',
                    'statusytm' => 'status_yatim_piatu',
                ];
                if (array_key_exists($field, $fieldMap) && $keyword != '') {
                    $dbField = $fieldMap[$field];
                    $Caris = Detailsiswa::With('KelasOne')->where('status_siswa', 'aktif')->where($dbField, 'like', '%' . $keyword . '%')->get();
                } else {
                    $Caris = collect(); // atau null / response error
                }
                $isiSiswa = '';
                foreach ($Caris as $siswa) {
                    $kelas = $siswa->kelas->kelas ?? '-';
                    $nis = $siswa->nis ?? '-';
                    $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis})\n";
                }
                $pesanKiriman =
                    "==================================\n" .
                    "📌 *Data $Kode Siswa*\n" .
                    "==================================\n\n" .
                    $isiSiswa . // <<<<< di sini masukin hasil foreach
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirim oleh:\n" .
                    "\t\t*Boot Asisten Pelayanan {$Identitas->namasek}*\n";

                // Log::info("Request received: Number - $number, Nis - $Part2 dan Kode = $Kode (Surat)");
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
