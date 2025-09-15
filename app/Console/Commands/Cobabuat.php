<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Admin\Identitas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Whatsapp\WhatsApp;

/*
|--------------------------------------------------------------------------
| 📌 CobaBuat
|--------------------------------------------------------------------------
|
| Fitur :
| -
|
| Tujuan :
| - Jelaskan tujuan command ini
| -
|
|
| Penggunaan :
| - Jelaskan penggunaannya dimana atau hubungannya
| -
|
||
*/

class Cobabuat extends Command
{
    protected $signature = 'siakad:cobabuat';
    protected $description = 'Pembuatan aplikasi coba';

    public function handle()
    {

        // $url = 'http://127.0.0.1:3000/send-message';

        // Laporan Dummy ke Kepala Sekolah (Test)
        // $response = Http::timeout(3)->post($url, [
        //     'id'      => config('whatsappSession.IdWaUtama');,
        //     'number'  => '6285329860005',
        //     'message' => 'Haloo bapak Kamad ini merupakan pesan pengingat otomatis, sesi GuruId!',
        // ]);

        //     $Tapels = Etapel::where('aktiv', 'Y')->first();
        //     $Identitas = Identitas::first();
        //     $message = 'Surat Aktif/Surat/250001/Lomba Cerdas Cermat';

        //     // Tuliskan logika command di sini
        //     $newpesan = explode('/', $message); // Format: "/aktif/beasiswa"
        //     $Kode = $newpesan[0];
        //     $Siswa = \App\Models\User\Siswa\Detailsiswa::with('KelasOne')->where('nis', $newpesan[2])->first();
        //     $Kelas = \App\Models\Admin\Ekelas::where('id', $Siswa->kelas_id)->first();
        //     // Pembuatan Surat
        //     // 📄 Data untuk PDF
        //     $data = [
        //         'nama'           => $Siswa->nama_siswa,
        //         'nis'           => $Siswa->nis,
        //         'kelas'          => $Siswa->KelasOne->kelas,
        //         'tempat_lahir'   => $Siswa->tempat_lahir,
        //         'tanggal_lahir'  => Carbon::create($Siswa->tanggal_lahir)->translatedformat('l, d F Y'),
        //         'keperluan'      => $newpesan[3],
        //         'nama_sekolah'      => $Identitas->namasek,
        //         'tahun_pelajaran'      => $Tapels->tapel . '-' . $Tapels->tapel + 1,
        //         'nama_kepsek'    => $Identitas->namakepala,
        //         'nip_kepala'     => $Identitas->nip ?? '-',
        //         'tanggal_surat'  => Carbon::create(now())->translatedformat('d F Y'),
        //         // 'nomor_surat'    => 'zzzz',
        //         'kabupaten'    => $Identitas->kabupaten,
        //         'lokasi_surat'   => 'Kota Edukasi',
        //     ];

        //     // 📂 Lokasi simpan PDF
        //     $folder = base_path('whatsapp/uploads'); // ini mengarah ke E:\laragon\www\siakad\whatsapp\uploads
        //     $filename = $Siswa->nis . '.pdf';
        //     $filepath = $folder . '/Surat Aktif-' . $filename;

        //     if (!File::exists($folder)) {
        //         File::makeDirectory($folder, 0755, true);
        //     }

        //     // 🖨️ Generate PDF
        //     // $pdf = Pdf::loadView('role.program.surat.surat-aktif-siswa', $data)->setOptions(['isRemoteEnabled' => true]);
        //     // $pdf = Pdf::loadView('role.program.surat.surat-aktif-siswa', $data)->setOptions(['isRemoteEnabled' => true]);
        //     // $pdf->save($filepath);

        //     // Chat Blasan dan Pengiriman File
        //     // 🟢 Buat pesan kiriman WA
        //     // $pesanKiriman =
        //     //     "==================================\n" .
        //     //     "📌 *Data Siswa ($Kode)*\n" .
        //     //     "==================================\n\n" .
        //     //     "📝 Nama\t\t\t: $Siswa->nama_siswa\n" .
        //     //     "🏫 Kelas\t\t\t: $Siswa->KelasOne->kelas\n" .
        //     //     "📅 Tanggal\t\t: " . Carbon::now()->translatedFormat('d F Y') . "\n\n" .
        //     //     str_repeat("─", 25) . "\n" .
        //     //     "📎 File Surat Aktif: sedang proses pembuatan\n" .
        //     //     "✍️ Dikirim oleh:\n" .
        //     //     "\t\t*Bot Asisten - {$Identitas->namasek}* \n";
        //     $pesanKiriman = PesanUmumSuratSiswa($Siswa->nis, $Kode);
        //     $this->info("Command 'KirimSesiWhatsapp' berhasil dijalankan." . $pesanKiriman);




        if (!config('whatsappSession.WhatsappDev')) {
            $Siswa = Detailsiswa::whereNotNull('kelas_id')->get();
        } else {
            $Siswa = Detailsiswa::whereNotNull('kelas_id')->limit(5)->get();
        }
        foreach ($Siswa as $siswa) {
            $sessions = config('whatsappSession.IdWaUtama');
            if (!config('whatsappSession.WhatsappDev')) {
                // $NoTujuan = $siswa->no_hp;
            } else {
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            // $pesan = json_encode(WaRekapTabunganBulanan($siswa->id));
            $pesan = tabungan_siswa($siswa->id);
            // $pesan = json_encode(tabungan_siswa($siswa->id));
            // $pesanx = WaRekapTabunganBulanan($siswa->id);
            // Kirim Pesan
            WhatsApp::sendMessage('GuruId', $NoTujuan, $pesan);
            // Tunggu 1 detik
            sleep(1);
        }
        // WhatsApp::sendMessage('GuruId', '6285329860005', 'hello coba');
    }
}
