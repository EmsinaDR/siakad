<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Admin\Identitas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\File;
use App\Models\User\Siswa\Detailsiswa;
use thiagoalessio\TesseractOCR\TesseractOCR;

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



        // if (is_day('sabtu')) {
        //     $this->info("Sabtu");
        // } elseif (is_day("jum'at")) {
        //     $this->info("Jumat");
        // } else {
        //     $this->info("hari senin - kami");
        // }






        $data = [
            230001,
            230002,
            230003,
            230004,
            230005,
            230006,
            230007,
            230008,
            230009,
            230010,
            230011,
            230012,
            230013,
            230014,
            230015,
            230016,
            230017,
            230018,
            230019,
            230020,
            230021,
            230022,
            230023,
            230024,
            230025,
            230026,
            230027,
            230028,
            230029,
            230030,
            240001,
            240002,
            240003,
            240004,
            240005,
            240006,
            240007,
            240008,
            240009,
            240010,
            240011,
            240012,
            240013,
            240014,
            240015,
            240016,
            240017,
            240018,
            240019,
            240020,
            240021,
            240022,
            240023,
            240024,
            240025,
            240026,
            240027,
            240028,
            240029,
            240030,
            240031,
            240032,
            240033,
            240034,
            240035,
            240037,
            240038,
            240040,
            240041,
            240043,
            240044,
            240045,
            240046,
            240047,
            240048,
            240050,
            240051,
            240052,
            240053,
            240054,
            240055,
            240056,
            240057,
            240058,
            240059,
            240060,
            240061,
            240062,
            240065,
            240066,
            240069,
            240073,
            240074,
            240075,
            240076,
            250006,
            250008,
            250018,
            250019,
            250024,
            250026,
            250030,
            250034,
            250035,
            250043,
            250045,
            250048,
            250049,
            250050,
            250051,
            250052,
            250053
        ];

        // $cekKarpels = Detailsiswa::get();
        // foreach ($cekKarpels as $cekKarpel):
        //     if (!in_array($cekKarpel->nis, $data)) {
        //         $this->info("{$cekKarpel->nama_siswa} => {$cekKarpel->nis} => {$cekKarpel->kelasOne->kelas}");
        //     };
        // endforeach;


        // // OCR
        // $basePath = public_path('img/siswa/kk');
        // $data = extract_kk_all($basePath, 'KK_new.jpg');
        // $data = extract_kk_all($basePath, 'kk.webp');
        // dd($data);

        // Membersihkan temp file bekas whatsapp dan log laravel
        // $file = 'executor\\pc\\cleaner-file.bat';
        // run_bating($file);


        $siswas = Detailsiswa::where('ibu_nohp', '52263')
            ->orWhere('ibu_nohp', 52263)
            ->get();

        foreach ($siswas as $siswa) {
            $waliNama = trim($siswa->wali_nama);

            // 1️⃣ Kosongkan ibu_nohp jika nilainya "52263"
            $siswa->ibu_nohp = null;

            // 2️⃣ Jika wali_nama berisi nomor HP (angka saja, boleh diawali +)
            if ($waliNama && preg_match('/^\+?\d+$/', $waliNama)) {
                $siswa->ibu_nohp = $waliNama;   // pindahkan ke ibu_nohp
                $siswa->wali_nama = null;       // kosongkan kolom wali_nama
            }

            $siswa->save();

            echo "✅ {$siswa->nama_siswa} diperbaiki. ibu_nohp = " . ($siswa->ibu_nohp ?? 'null') . "\n";
        }




        // if (!config('whatsappSession.WhatsappDev')) {
        //     $Siswa = Detailsiswa::whereNotNull('kelas_id')->get();
        // } else {
        //     $Siswa = Detailsiswa::whereNotNull('kelas_id')->limit(5)->get();
        // }
        // foreach ($Siswa as $siswa) {
        //     $sessions = config('whatsappSession.IdWaUtama');
        //     if (!config('whatsappSession.WhatsappDev')) {
        //         // $NoTujuan = $siswa->no_hp;
        //     } else {
        //         $NoTujuan = config('whatsappSession.DevNomorTujuan');
        //     }
        //     // $pesan = json_encode(WaRekapTabunganBulanan($siswa->id));
        //     $pesan = tabungan_siswa($siswa->id);
        //     // $pesan = json_encode(tabungan_siswa($siswa->id));
        //     // $pesanx = WaRekapTabunganBulanan($siswa->id);
        //     // Kirim Pesan
        //     WhatsApp::sendMessage('GuruId', $NoTujuan, $pesan);
        //     // Tunggu 1 detik
        //     sleep(1);
        // }
        // WhatsApp::sendMessage('GuruId', '6285329860005', 'hello coba');
    }
}
