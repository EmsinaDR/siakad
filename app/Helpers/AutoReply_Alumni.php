<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 Auto_reply_alumni :
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
if (!function_exists('Auto_reply_alumni')) {
    function Auto_reply_alumni($Kode, $NoRequest, $message)
    {
        // TODO: Implement your helper logic here
        // Kode / Alumni / kode guru /
        $pesan = explode('/', $message);
        // $kodeGuru = $pesan[2];
        // $Guru = Detailguru::where('kode_guru', $kodeGuru)->first();
        if (!config('whatsappSession.WhatsappDev')) {
            //$sessions = getWaSession(siswa->tingkat_id); // by tingkat ada di dalamnya
            $sessions = config('whatsappSession.IdWaUtama');
            //NoTujuan = getNoTujuanOrtu(siswa)
            // $NoTujuan = $NoRequest;
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        switch ($Kode) {
            case 'Data Alumnix':
                // Data Alumni/Alumni/tahun_lulus
                $tahun = $pesan[2];
                $tapel = CariTapelLulusan($tahun);

                $DataAlumni = Detailsiswa::where('status_siswa', 'lulus')
                    ->where('tahun_lulus', $tapel)
                    ->get();

                if ($DataAlumni->isEmpty()) {
                    $PesanKirim = "Data Tidak Ditemukan\n\n";
                } else {

                    $PesanKirim =
                        "Jumlah Masuk : {$DataAlumni->count()}\n" .
                        "Jumlah Lulusan : {$DataAlumni->count()}\n\n";
                }

                \App\Models\Whatsapp\WhatsApp::sendMessage(
                    $sessions,
                    $NoRequest,
                    format_pesan('judul', $PesanKirim)
                );
                break;

            case 'Rekap Alumni':
                // Format: Rekap Alumni/Alumni/nis (contoh: Rekap Alumni/Alumni/24)
                $kodeAwal = $pesan[2] ?? null;

                if (!$kodeAwal) {
                    $PesanKirim = "Format salah.\nGunakan: Rekap Alumni/Alumni/<dua_digit_awal_nis>\nContoh: Rekap Alumni/Alumni/24";
                    \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('judul', $PesanKirim));
                    break;
                }

                $RekapSiswa = Detailsiswa::select('status_siswa', DB::raw('COUNT(*) as jumlah'))
                    ->where('nis', 'like', $kodeAwal . '%')
                    ->groupBy('status_siswa')
                    ->orderBy('status_siswa')
                    ->get();

                if ($RekapSiswa->isEmpty()) {
                    $PesanKirim = "Tidak ditemukan data siswa dengan NIS diawali $kodeAwal.";
                } else {
                    $PesanKirim = "📊 *Rekap Data Alumni NIS diawali $kodeAwal*\n\n";
                    foreach ($RekapSiswa as $row) {
                        $PesanKirim .= ucfirst($row->status_siswa) . " : " . $row->jumlah . " siswa\n";
                    }
                }

                \App\Models\Whatsapp\WhatsApp::sendMessage(
                    $sessions,
                    $NoRequest,
                    format_pesan('judul', $PesanKirim)
                );

                break;
            case 'Data Alumni':
                // Format: Data Alumni/Alumni/25/pdf
                $kodeAwal = (int)$pesan[2] - 3 ?? null;
                $modePdf = isset($pesan[3]) && strtolower($pesan[3]) === 'pdf';
                if (!$kodeAwal) {
                    $PesanKirim = "Format salah.\nGunakan: Data Alumni/Alumni/<dua_digit_awal_nis>/pdf\nContoh: Data Alumni/Alumni/24/pdf";
                    \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('judul', $PesanKirim));
                    break;
                }

                // Ambil data alumni yang nis diawali dengan kode
                $DataAlumni = Detailsiswa::where('nis', 'like', $kodeAwal . '%')
                    ->whereRaw('LOWER(status_siswa) = ?', ['lulus'])
                    ->select('nama_siswa', 'nis', 'nisn', 'nohp_siswa', 'alamat_siswa')
                    ->orderBy('nama_siswa')
                    ->get();


                if ($DataAlumni->isEmpty()) {
                    $PesanKirim = "Tidak ditemukan data alumni dengan NIS diawali *{$kodeAwal}* mungkin saat ini masih aktif.";
                    \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Alumni', $PesanKirim));
                    break;
                }

                // Kalau bukan mode PDF, kirim rekap singkat via WhatsApp
                if (!$modePdf) {
                    $PesanKirim = "📚 *Data Alumni Angkatan {$kodeAwal}*\n";
                    $PesanKirim .= "Total Lulusan: " . $DataAlumni->count() . " siswa\n\n";
                    $PesanKirim .= "Gunakan perintah: Data Alumni/Alumni/{$kodeAwal}/pdf untuk ekspor lengkap dalam bentuk file PDF.";
                    \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, format_pesan('Data Alumni', $PesanKirim));
                    break;
                }

                // ==========================
                // 💾 Generate PDF pakai DomPDF
                // ==========================
                $judul = "DATA ALUMNI ANGKATAN MASUK TAHUN 20{$kodeAwal}";
                $tanggal = now()->format('d/m/Y H:i');

                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('role.alumni.data-alumni-export', [
                    'judul' => $judul,
                    'tanggal' => $tanggal,
                    'alumni' => $DataAlumni,
                    'angkatan' => $kodeAwal,
                ])->setPaper('a4', 'portrait');

                $filename = 'data_alumni_' . $kodeAwal . '_' . date('Ymd_His') . '.pdf';
                $savePath = base_path("whatsapp/uploads/{$filename}");
                $pdf->save($savePath);

                // ==========================
                // 📩 Kirim ke WhatsApp
                // ==========================
                $caption = "📄 Data alumni angkatan {$kodeAwal} berhasil diekspor!\nTotal: " . $DataAlumni->count() . " siswa.";
                \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $savePath);

                return response()->json([
                    'status' => 'ok',
                    'file' => $filename,
                ]);

                break;

            case 'Cek Alumni':
                // Cek Alumni/Alumni/nis
                // Log::info("Request received: Number - $number, Nis - $nis dan Kode = $Kode");
                $pesanKiriman =
                    "Berikut informasi Data Alumni :\n" .
                    "\n";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                break;
            default:
                $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                break;
        }
    }
}
