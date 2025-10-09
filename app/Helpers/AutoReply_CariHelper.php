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
            case 'Siswa':
                // Konsep Untuk Kirim dan Buat Surat Lewat Whatsapp
                // Format perintah:
                // Siswa/Cari/key/pencarian
                // Contoh:
                // Siswa/Cari/kelas/VII A
                // Siswa/Cari/nama/xxxx
                // Siswa/Cari/alamat/xxxx
                // Siswa/Cari/nis/2025xx
                // Siswa/Cari/statusytm/yatim:piatu:yatim piatu:lengkap
                // Siswa/Cari/umur/11
                // Cari/Siswa

                $field = $data[2] ?? ''; // ambil field pencarian
                if ($field === 'kelas') {
                    // khusus pencarian kelas (karena kelas pakai ID)
                    $etapels = Etapel::where('aktiv', 'Y')->first();
                    $kelasId = Ekelas::where('tapel_id', $etapels->id)->where('kelas', $data[3])->first();
                    $keyword = $kelasId->id ?? ''; // jika kelas tidak ditemukan → kosong
                } else {
                    $keyword = $data[3] ?? ''; // ambil keyword pencarian
                }

                // mapping field agar aman (hindari SQL injection dan typo)
                $fieldMap = [
                    'nama' => 'nama_siswa',
                    'nis' => 'nis',
                    'alamat' => 'alamat_siswa',
                    'kelas' => 'kelas_id',
                    'statusytm' => 'status_yatim_piatu',
                    // 'umur' tidak ada di DB, jadi harus dihandle manual dengan TIMESTAMPDIFF
                ];

                if ($field === 'umur' && $keyword != '') {
                    // pencarian berdasarkan umur (hitung dari tanggal_lahir)
                    $Caris = Detailsiswa::with('KelasOne')
                        ->where('status_siswa', 'aktif')
                        ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) = ?', [$keyword])
                        ->get();
                } elseif (array_key_exists($field, $fieldMap) && $keyword != '') {
                    // pencarian field biasa (nama, nis, alamat, kelas, statusytm)
                    $dbField = $fieldMap[$field];
                    $Caris = Detailsiswa::with('KelasOne')
                        ->where('status_siswa', 'aktif')
                        ->where($dbField, 'like', '%' . $keyword . '%')
                        ->get();
                } else {
                    // kalau field tidak cocok → kembalikan kosong
                    $Caris = collect();
                }

                // format hasil pencarian
                $isiSiswa = '';
                foreach ($Caris as $siswa) {
                    $kelas = $siswa->kelas->kelas ?? '-'; // ambil nama kelas
                    $nis = $siswa->nis ?? '-'; // ambil NIS
                    $umur = umursiswa($siswa->tanggal_lahir); // fungsi helper hitung umur
                    $isiSiswa .= "📝 {$siswa->nama_siswa} ({$kelas} - {$nis}) | {$umur} th\n";
                }

                // pesan kiriman ke WhatsApp
                $pesanKiriman =
                    "==================================\n" .
                    "📌 *Data $Kode Siswa*\n" .
                    "==================================\n\n" .
                    ($isiSiswa ?: "⚠️ Tidak ada data ditemukan.\n") . // fallback kalau kosong
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirim oleh:\n" .
                    "\t\t*Boot Asisten Pelayanan {$Identitas->namasek}*\n";

                // kirim ke WhatsApp Gateway
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;

            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
