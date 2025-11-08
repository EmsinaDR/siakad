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

use Illuminate\Support\Str;
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
        //         'nama_siswa'           => $Siswa->nama_siswa,
        //         'nis'           => $Siswa->nis,
        //         'kelas'          => $Siswa->KelasOne->kelas,
        //         'tempat_lahir'   => $Siswa->tempat_lahir,
        //         'tanggal_lahir'  => Carbon::create($Siswa->tanggal_lahir)->translatedformat('l, d F Y'),
        //         'keperluan'      => $newpesan[3],
        //         'nama_siswa_sekolah'      => $Identitas->nama_siswasek,
        //         'tahun_pelajaran'      => $Tapels->tapel . '-' . $Tapels->tapel + 1,
        //         'nama_siswa_kepsek'    => $Identitas->nama_siswakepala,
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
        //     //     "📝 nama_siswa\t\t\t: $Siswa->nama_siswa\n" .
        //     //     "🏫 Kelas\t\t\t: $Siswa->KelasOne->kelas\n" .
        //     //     "📅 Tanggal\t\t: " . Carbon::now()->translatedFormat('d F Y') . "\n\n" .
        //     //     str_repeat("─", 25) . "\n" .
        //     //     "📎 File Surat Aktif: sedang proses pembuatan\n" .
        //     //     "✍️ Dikirim oleh:\n" .
        //     //     "\t\t*Bot Asisten - {$Identitas->nama_siswasek}* \n";
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



        // // Belum update server utama
        // Detailsiswa::whereIn('ibu_penghasilan', ['1000000', '1 Jt', '1.000.000'])
        //     ->update([
        //         'ibu_penghasilan' => '1000000',
        //     ]);
        // Detailsiswa::whereIn('ibu_penghasilan', ['2,000,000'])
        //     ->update([
        //         'ibu_penghasilan' => '2000000',
        //     ]);
        // Detailsiswa::whereIn('ibu_penghasilan', ['2,500,000'])
        //     ->update([
        //         'ibu_penghasilan' => '2500000',
        //     ]);
        // Detailsiswa::whereIn('ibu_penghasilan', ['500000', '500.000', '500,000'])
        //     ->update([
        //         'ibu_penghasilan' => '500000',
        //     ]);

        // Detailsiswa::whereIn('ayah_penghasilan', ['1000000', '1 Jt', '1.000.000', '1,000,000'])
        //     ->update([
        //         'ayah_penghasilan' => '1000000',
        //     ]);
        // Detailsiswa::whereIn('ayah_penghasilan', ['1,500,000'])
        //     ->update([
        //         'ayah_penghasilan' => '1500000',
        //     ]);
        // Detailsiswa::whereIn('ayah_penghasilan', ['2,000,000'])
        //     ->update([
        //         'ayah_penghasilan' => '2000000',
        //     ]);
        // Detailsiswa::whereIn('ayah_penghasilan', ['2,500,000'])
        //     ->update([
        //         'ayah_penghasilan' => '2500000',
        //     ]);
        // Detailsiswa::whereIn('ayah_penghasilan', ['500000', '500.000', '500,000'])
        //     ->update([
        //         'ayah_penghasilan' => '500000',
        //     ]);
        // Detailsiswa::whereIn('ayah_penghasilan', ['5.000.000', '5.000.000'])
        //     ->update([
        //         'ayah_penghasilan' => '5000000',
        //     ]);
        // Detailsiswa::whereIn('ayah_penghasilan', ['3,500,000'])
        //     ->update([
        //         'ayah_penghasilan' => '3500000',
        //     ]);
        // Detailsiswa::whereIn('ayah_penghasilan', ['8,000,000'])
        //     ->update([
        //         'ayah_penghasilan' => '8000000',
        //     ]);

        // Detailsiswa::whereIn('piket_kelas', ["Jumat", "Jum\'at"])
        //     ->update([
        //         'piket_kelas' => "Jum'at",
        //     ]);

        // // Hobi
        // Detailsiswa::whereIn('hobi', ["Bermain Sepak Bola", "Sepak Bola", "Maen Bola", "Main Bola"])
        //     ->update([
        //         'hobi' => "Sepak Bola",
        //     ]);
        // Detailsiswa::whereIn('hobi', ["Berolahraga", "Olahraga", "Latihan Fisik"])
        //     ->update([
        //         'hobi' => "Berolahraga",
        //     ]);
        // Detailsiswa::whereIn('hobi', ["Bermain Layangan", "Layangan"])
        //     ->update([
        //         'hobi' => "Bermain Layangan",
        //     ]);
        // Detailsiswa::whereIn('hobi', ["Bermain Game", "Main Game"])
        //     ->update([
        //         'hobi' => "Bermain Game",
        //     ]);
        // Detailsiswa::whereIn('hobi', ["Renang", "Berenang"])
        //     ->update([
        //         'hobi' => "Berenang",
        //     ]);

        // Detailsiswa::whereIn('hobi', ["Badminton", "Bulutangkis"])
        //     ->update([
        //         'hobi' => "Bulu tangkis",
        //     ]);
        // Detailsiswa::whereIn('hobi', ["Mengambar", "Bulutangkis"])
        //     ->update([
        //         'hobi' => "Menggambar",
        //     ]);
        // Detailsiswa::whereIn('hobi', ["Sholawat", "Sholawatan", "Solawatan"])
        //     ->update([
        //         'hobi' => "Bershalawat",
        //     ]);
        // // nama_siswa Sekolah Asal
        // Detailsiswa::whereIn('nama_siswasek_asal', ["MI I'anatul Muta'allimin 01", "MI I'anatul mutaallimin 01 kubangwungu",])
        //     ->update([
        //         'nama_siswasek_asal' => "MI I'anatul Muta'allimin 01",
        //     ]);
        // Detailsiswa::whereIn('nama_siswasek_asal', ["MI I'anatul mutaallimin 02 kubangwungu", "MI I'anatul mutaallimin 01 kubangwungu",])
        //     ->update([
        //         'nama_siswasek_asal' => "MI I'anatul Muta'allimin 02",
        //     ]);
        // Detailsiswa::whereIn('nama_siswasek_asal', ["SD Negeri 01 Kubangwungi", "SD Negeri Kubangwungu 01", "SDN Kubangwungu 01"])
        //     ->update([
        //         'nama_siswasek_asal' => "SD Negeri 01 Kubangwungu",
        //     ]);
        // Detailsiswa::whereIn('nama_siswasek_asal', ["SDN Kubangwungu 02", "SD N Kubangwungu 02"])
        //     ->update([
        //         'nama_siswasek_asal' => "SD Negeri 02 Kubangwungu",
        //     ]);
        // Detailsiswa::whereIn('nama_siswasek_asal', ["SDN Kubangsari 01"])
        //     ->update([
        //         'nama_siswasek_asal' => "SD Negeri 01 Kubangsari",
        //     ]);
        // Detailsiswa::whereIn('nama_siswasek_asal', ["SD Kubangsari 02", "SDN Kubangsari 02"])
        //     ->update([
        //         'nama_siswasek_asal' => "SD Negeri 02 Kubangsari",
        //     ]);
        // Detailsiswa::whereIn('nama_siswasek_asal', ["SDN Ketanggungan 08"])
        //     ->update([
        //         'nama_siswasek_asal' => "SD Negeri 08 Ketanggungan",
        //     ]);
        // // jabatan
        // Detailsiswa::whereIn('jabatan_kelas', ["Wakil Ketua Kelas", "Wakil Ketua"])
        //     ->update([
        //         'jabatan_kelas' => "Wakil Ketua",
        //     ]);
        // Detailsiswa::whereIn('jabatan_kelas', ["Ketua"])
        //     ->update([
        //         'jabatan_kelas' => "Ketua Kelas",
        //     ]);
        // Detailsiswa::whereIn('jabatan_kelas', ["Siswa"])
        //     ->update([
        //         'jabatan_kelas' => "Anggota",
        //     ]);
        // Detailsiswa::whereIn('jabatan_kelas', ["Sekertaris"])
        //     ->update([
        //         'jabatan_kelas' => "Sekretaris",
        //     ]);
        // Detailsiswa::whereIn('jabatan_kelas', ["Seksi Keamanan"])
        //     ->update([
        //         'jabatan_kelas' => "Sie. Keamanan",
        //     ]);
        // Detailsiswa::whereIn('nis', ['250001', '230017', '230018', '230028', '240034', '240065', '250003', '250009', '250016', '250021', '250030', '250039'])
        //     ->update([
        //         'nama_siswasek_asal' => "SD Negeri 02 Kubangwungu",
        //     ]);


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


        // Haji
        // =============================================
        //  AUTO GENERATE SEMUA SVG (kartu & stiker)
        // =============================================
        // $data = [
        //     ['nama_siswa' => 'INTAN RATNA PURnama_siswaSARI', 'Alamat' => 'LUWUNGRAGI RT. 05 RW. 04 BULAKAMBA BREBES 52253', 'alamat' => 'LUWUNGRAGI RT. 05 RW. 04 ', 'kecamatan' => 'BULAKAMBA ', 'kabupaten' => 'BREBES', 'kode_pos' => '52253', 'no_hp' => 'X6392292', 'passport' => '+62 852.1352.5655', 'foto' => '01 Intan.jpg'],
        //     ['nama_siswa' => 'ITA SARI SALIP', 'Alamat' => 'LUWUNGRAGI RT. 05 RW. 04 BULAKAMBA BREBES 52253', 'alamat' => 'LUWUNGRAGI RT. 05 RW. 04 ', 'kecamatan' => 'BULAKAMBA ', 'kabupaten' => 'BREBES', 'kode_pos' => '52253', 'no_hp' => 'X6392291', 'passport' => '+62 852.1352.5655', 'foto' => '02 Ita Sari.jpg'],
        //     ['nama_siswa' => 'WAMID SAKRAM SARNGAD', 'Alamat' => 'KALIGANGSA RT. 03 RW. 03 TEGAL', 'alamat' => 'KALIGANGSA RT. 03 RW. 03 ', 'kecamatan' => 'Margadana', 'kabupaten' => 'TEGAL', 'kode_pos' => '52147', 'no_hp' => 'X6392289', 'passport' => '+62 895.4228.31598', 'foto' => '03 Wamid.jpg'],
        //     ['nama_siswa' => 'MAKHDORI SUDJANTO WASMUN', 'Alamat' => 'KALIGANGSA WETAN JLN. BIMA VII ', 'alamat' => 'KALIGANGSA WETAN JLN. BIMA VII ', 'kecamatan' => 'Margadana', 'kabupaten' => 'TEGAL', 'kode_pos' => '52147', 'no_hp' => 'X6392290', 'passport' => '+62 896.3236.4042', 'foto' => '04 Makhdori Sudjanto.jpg'],
        //     ['nama_siswa' => 'WARSITI KARMEN KAGIM', 'Alamat' => 'KARANGSEMBUNG RT. 04 RW. 01 SONGGOM 52266', 'alamat' => 'KARANGSEMBUNG RT. 04 RW. 01 ', 'kecamatan' => 'SONGGOM', 'kabupaten' => 'BREBES', 'kode_pos' => '52266', 'no_hp' => 'X6392293', 'passport' => '+62 857.1827.0040', 'foto' => '05 Warsiti.jpg'],
        //     ['nama_siswa' => 'ASIKIN DULALIM WARTAM', 'Alamat' => 'RANCAWULUH RT. 02 RW. 02 BULAKAMBA BREBES 52253', 'alamat' => 'RANCAWULUH RT. 02 RW. 02 ', 'kecamatan' => 'BULAKAMBA ', 'kabupaten' => 'BREBES', 'kode_pos' => '52253', 'no_hp' => 'X6059242', 'passport' => '+62 852.2945.4877', 'foto' => '06 Asikin.jpg'],
        //     ['nama_siswa' => 'FARIDAH M ALI MULYAREJA', 'Alamat' => 'RANCAWULUH RT. 02 RW. 02 BULAKAMBA  BREBES 52253', 'alamat' => 'RANCAWULUH RT. 02 RW. 02 ', 'kecamatan' => 'BULAKAMBA  ', 'kabupaten' => 'BREBES', 'kode_pos' => '52253', 'no_hp' => 'X6959241', 'passport' => '+62 851.8503.2521', 'foto' => '07 Faridah.jpg'],
        //     ['nama_siswa' => 'SAKWAD RAWAD SUJA', 'Alamat' => 'DUKUHWRINGIN RT. 023 RW. 10  WANASARI BREBES 52252', 'alamat' => 'DUKUHWRINGIN RT. 023 RW. 10  ', 'kecamatan' => 'WANASARI ', 'kabupaten' => 'BREBES', 'kode_pos' => '52252', 'no_hp' => 'X6392015', 'passport' => '+62 858.6719.3935', 'foto' => '08 Sakwid.jpg'],
        //     ['nama_siswa' => 'SITI SONDARI WARLAN', 'Alamat' => 'DUKUHWRINGIN RT. 023 RW. 10 WANASARI BREBES 52252', 'alamat' => 'DUKUHWRINGIN RT. 023 RW. 10 ', 'kecamatan' => 'WANASARI ', 'kabupaten' => 'BREBES', 'kode_pos' => '52252', 'no_hp' => 'X6392014', 'passport' => '+62 858.6719.3935', 'foto' => '09 SITI SONDARI WARLAN.jpg'],
        //     ['nama_siswa' => 'ABDURROKHMAN ABDUL AZIZ', 'Alamat' => 'SIWULUH RT. 01 RW. 01 BULAKAMBA BREBES 52253', 'alamat' => 'SIWULUH RT. 01 RW. 01 ', 'kecamatan' => 'BULAKAMBA ', 'kabupaten' => 'BREBES', 'kode_pos' => '52253', 'no_hp' => 'X6059001', 'passport' => '+62 823.2660.6681', 'foto' => '10 Abdurrokhman.jpg'],
        //     ['nama_siswa' => 'ZAENAL ARIFIN AKHMAD MAWARDI', 'Alamat' => 'SIWULUH RT. 01 RW. 01 BULAKAMBA BREBES 52253', 'alamat' => 'SIWULUH RT. 01 RW. 01 ', 'kecamatan' => 'BULAKAMBA ', 'kabupaten' => 'BREBES', 'kode_pos' => '52253', 'no_hp' => 'X6391589', 'passport' => '+62 823.2660.6681', 'foto' => '11 Zaenal Arifin.jpg'],
        //     ['nama_siswa' => 'IDHAM MAHDIANA AHMAD RENDI RIFAI', 'Alamat' => 'BANJARHARJO RT. 10 RW. 01 BANJARHARJO BREBES 52265', 'alamat' => 'BANJARHARJO RT. 10 RW. 01 ', 'kecamatan' => 'BANJARHARJO ', 'kabupaten' => 'BREBES', 'kode_pos' => '52265', 'no_hp' => 'X6391920', 'passport' => '+62 819.0239.6239', 'foto' => '12 IDHAM MAHDIANA.jpg'],
        //     ['nama_siswa' => 'UNI TRI LESTARI ', 'Alamat' => 'BANJARHARJO RT. 10 RW. 01 BANJARHARJO BREBES 52265', 'alamat' => 'BANJARHARJO RT. 10 RW. 01 ', 'kecamatan' => 'BANJARHARJO ', 'kabupaten' => 'BREBES', 'kode_pos' => '52265', 'no_hp' => 'X6391921', 'passport' => '+62 819.0270.5234', 'foto' => '13 UNI TRI LESTARI.jpg'],
        //     ['nama_siswa' => 'DJUWARIJAH SARAH SALEH', 'Alamat' => 'BANJARHARJO RT. 10 RW. 01 BANJARHARJO BREBES 52265', 'alamat' => 'BANJARHARJO RT. 10 RW. 01 ', 'kecamatan' => 'BANJARHARJO ', 'kabupaten' => 'BREBES', 'kode_pos' => '52265', 'no_hp' => 'E8062318', 'passport' => '+62 819.0270.2323', 'foto' => '14 DJUWARIYAH.jpg'],
        //     ['nama_siswa' => 'SITI KHORIDAH ACH RENDI RIFAI', 'Alamat' => 'PALASARI RT. 06 RW. 08 CIBIRU BANDUNG 40615', 'alamat' => 'PALASARI RT. 06 RW. 08', 'kecamatan' => 'CIBIRU', 'kabupaten' => 'BANDUNG', 'kode_pos' => '40615', 'no_hp' => 'X6392187', 'passport' => '+62 857.5911.8887', 'foto' => '15 Siti Khoridah.jpg'],
        //     ['nama_siswa' => 'MUSLIHAH KARMAD SUMANTA', 'Alamat' => 'BANJARHARJO RT. 08 RW. 01 BANJARHARJO BREBES 52265', 'alamat' => 'BANJARHARJO RT. 08 RW. 01 ', 'kecamatan' => 'BANJARHARJO ', 'kabupaten' => 'BREBES', 'kode_pos' => '52265', 'no_hp' => 'X7072100', 'passport' => '+62 819.0213.1888', 'foto' => '16 MUSLIHAH.jpg'],
        //     ['nama_siswa' => 'HAERUDIN ROSID TOHARI', 'Alamat' => 'BANJARHARJO RT. 08 RW. 01 BANJARHARJO BREBES 52265', 'alamat' => 'BANJARHARJO RT. 08 RW. 01 ', 'kecamatan' => 'BANJARHARJO ', 'kabupaten' => 'BREBES', 'kode_pos' => '52265', 'no_hp' => 'C8745768', 'passport' => '+61 487.026.365', 'foto' => '17 HAERUDIN.jpg'],
        //     ['nama_siswa' => 'DARYUNI JAYA NAYA BANGSA', 'Alamat' => 'PAREREJA RT. 04 RW. 03 BANJARHARJO BREBES 52265', 'alamat' => 'PAREREJA RT. 04 RW. 03 ', 'kecamatan' => 'BANJARHARJO ', 'kabupaten' => 'BREBES', 'kode_pos' => '52265', 'no_hp' => 'X7072099', 'passport' => '+62 881.2605.973', 'foto' => '18 DARYUNI.jpg'],
        //     ['nama_siswa' => 'SAHERI MAJANI KARTARAKSA', 'Alamat' => 'PAREREJA RT. 04 RW. 03 BANJARHARJO BREBES 52265', 'alamat' => 'PAREREJA RT. 04 RW. 03 ', 'kecamatan' => 'BANJARHARJO ', 'kabupaten' => 'BREBES', 'kode_pos' => '52265', 'no_hp' => 'X7072096', 'passport' => '+62 881.2605.973', 'foto' => '19 SAHERI.jpg'],
        //     ['nama_siswa' => 'AGUNG NUGROHO SULAMTO', 'Alamat' => 'jln Pramuka 39 Jatibarang Kidul 52261', 'alamat' => 'JLN PRAMUKA 39 ', 'kecamatan' => 'Jatibarang Kidul ', 'kabupaten' => 'BREBES', 'kode_pos' => '52261', 'no_hp' => 'X7072137', 'passport' => '+62 857.1670.9499', 'foto' => '20 AGUNG NUGROHO SULAMTO.jpg'],
        //     ['nama_siswa' => 'DEWI MULYASARI ABDUL KHALIM', 'Alamat' => 'jln Pramuka 39 Jatibarang Kidul', 'alamat' => 'JLN PRAMUKA 39 ', 'kecamatan' => 'Jatibarang Kidul', 'kabupaten' => 'BREBES', 'kode_pos' => '52261', 'no_hp' => 'X7072136', 'passport' => '+62 857.2588.4454', 'foto' => '21 DEWI MULYASARI ABDUL KHALIM.jpg'],
        //     ['nama_siswa' => 'SUTRISNO SAKWAN DASKAM', 'Alamat' => 'PEMARON RT. 02 RW. 07 BREBES 52219', 'alamat' => 'PEMARON RT. 02 RW. 07 ', 'kecamatan' => 'Brebes', 'kabupaten' => 'BREBES', 'kode_pos' => '52219', 'no_hp' => 'X7072098', 'passport' => '+62 813.1685.2551', 'foto' => '22 Sutrisno bin Sakiwan Daskam.jpg'],
        //     ['nama_siswa' => 'DARUDIN KAMUD', 'Alamat' => 'DUKUH LAMARAN, SITANGGAL RT. 03 RW. 07 LARANGAN 52262', 'alamat' => 'DUKUH LAMARAN, SITANGGAL RT. 03 RW. 07 ', 'kecamatan' => 'LARANGAN ', 'kabupaten' => 'BREBES', 'kode_pos' => '52262', 'no_hp' => 'X6391756', 'passport' => '+62 838.9864.8731', 'foto' => '23 DARUDIN.jpg'],
        //     ['nama_siswa' => 'KHUSNUL KHOTIMAH', 'Alamat' => 'DUKUH LAMARAN, SITANGGAL RT. 03 RW. 07 LARANGAN 52262', 'alamat' => 'DUKUH LAMARAN, SITANGGAL RT. 03 RW. 07 ', 'kecamatan' => 'LARANGAN ', 'kabupaten' => 'BREBES', 'kode_pos' => '52262', 'no_hp' => 'X6391755', 'passport' => '+62 856.4732.2689', 'foto' => '24 KHUSNUL KHOTIMAH.jpg'],
        //     ['nama_siswa' => 'AMINAH SAHURI', 'Alamat' => 'DUKUH LAMARAN, SITANGGAL RT. 03 RW. 07 LARANGAN 52262', 'alamat' => 'DUKUH LAMARAN, SITANGGAL RT. 03 RW. 07 ', 'kecamatan' => 'LARANGAN ', 'kabupaten' => 'BREBES', 'kode_pos' => '52262', 'no_hp' => 'X6391757', 'passport' => '+62 856.4732.2689', 'foto' => '25 AMINAH.jpg'],
        //     ['nama_siswa' => 'SAIDAH DUSMAN', 'Alamat' => 'DUKUH LAMARAN, SITANGGAL RT. 07  RW. 09 LARANGAN 52262', 'alamat' => 'DUKUH LAMARAN, SITANGGAL RT. 07  RW. 09 ', 'kecamatan' => 'LARANGAN ', 'kabupaten' => 'BREBES', 'kode_pos' => '52262', 'no_hp' => 'X6391754', 'passport' => '+62 838.9338.2470', 'foto' => '26 Saidah.jpg'],
        //     ['nama_siswa' => 'FAIZIN MUSLIH SOLEH', 'Alamat' => 'LUWUNGRAGI RT. 02 RW. 04 BULAKAMBA BREBES 52253', 'alamat' => 'LUWUNGRAGI RT. 02 RW. 04 ', 'kecamatan' => 'BULAKAMBA ', 'kabupaten' => 'BREBES', 'kode_pos' => '52253', 'no_hp' => 'E2520017', 'passport' => '+62 896.3236.4042', 'foto' => '27 FAIZIN.jpg'],
        // ];
        // // 🔁 Loop semua data jamaah
        // foreach ($data as $index => $dataq):
        //     // Cetak versi kartu
        //     $resulter = svghaji($index + 1, $dataq, 'templatex.svg', 'backgroundx.png');


        //     // Cetak versi stiker
        //     // svghaji($index + 1, $dataq, 'sticker.svg', 'bc_sticker.png');
        //     $this->info("Command 'CetakAbsensiCommand' berhasil dijalankan. {$dataq['nama_siswa']}");
        // endforeach;
        // // foreach ($data as $index => $dataq):
        // //     $url = replacesvgvariabel([
        // //         'nama_siswa'            => $dataq['nama_siswa'],
        // //         'passport'        => $dataq['passport'],
        // //         'alamat'          => $dataq['alamat'],
        // //         'template_path'   => public_path('img/template/haji/template.svg'),

        // //         // Gambar dinamis (sebanyak apapun bisa)
        // //         'foto'            => public_path('img/foto/' . $dataq['nama_siswa'] . '.png'),
        // //         'img_qrcode'      => public_path('img/qrcode/' . $dataq['passport'] . '.png'),
        // //         'img_logo'        => 'https://example.com/logo.png',
        // //         'img_ttd'         => public_path('img/stempel/ttd.png'),
        // //         'img_cap'         => public_path('img/stempel/cap.png'),
        // //         'background'      => public_path('img/template/haji/background.png'),
        // //     ], 'haji_');
        // // endforeach;

        $akhirBulan = CekAkhirBulan();
        if ($akhirBulan) {
            $pesan = 'Benar';
        } else {
            $pesan = 'Salah';
        }
        // $this->info("Command 'KirimSesiWhatsapp' berhasil dijalankan." . $pesan);
        // Detailsiswa::where('ayah_nohp', '')
        //     ->update(['ayah_nohp' => null]);

        // Detailsiswa::where('ibu_nohp', '')
        //     ->update(['ibu_nohp' => null]);


        // C:\laragon\www\siakad\public\storage\tmp


        // $nisTarget = '250015';
        // $kelas = 7;

        // $noUrut = DetailSiswa::where('tingkat_id', $kelas)
        //     ->orderBy('nis', 'asc')
        //     ->pluck('nis')   // ambil semua NIS kelas tsb dalam urutan NIS
        //     ->search($nisTarget);  // cari index-nya di collection

        // if ($noUrut !== false) {
        //     $noUrut = $noUrut + 1; // karena index dimulai dari 0
        //     echo "No urut siswa dengan NIS $nisTarget di kelas $kelas adalah: $noUrut";
        // } else {
        //     echo "NIS $nisTarget tidak ditemukan di kelas $kelas.";
        // }





        // // Pembagian ruangan
        // $pasanganPerGrup = 15; // jumlah pasangan per grup/ruang

        // // 1️⃣ Ambil semua siswa urut berdasarkan kelas dan NIS
        // $siswaList = DetailSiswa::orderBy('tingkat_id', 'asc')
        //     ->orderBy('nis', 'asc')
        //     ->get(['nis', 'nama_siswa', 'tingkat_id']);

        // // 2️⃣ Kelompokkan berdasarkan kelas
        // $byKelas = $siswaList->groupBy('tingkat_id');

        // // 3️⃣ Siapkan array untuk pasangan lintas kelas
        // $pasangan = [];

        // // 4️⃣ Buat iterator untuk setiap kelas agar bisa pairing antar kelas
        // $kelasArrays = [];
        // foreach ($byKelas as $tingkat => $list) {
        //     $kelasArrays[$tingkat] = $list->values()->toArray();
        // }

        // // Ambil semua tingkat_id yang ada
        // $tingkatList = array_keys($kelasArrays);
        // $jumlahKelas = count($tingkatList);

        // // Buat indeks awal untuk tiap kelas
        // $indexKelas = array_fill_keys($tingkatList, 0);

        // // 5️⃣ Loop buat pairing lintas kelas
        // while (true) {
        //     // ambil dua kelas berbeda yang masih punya siswa
        //     $kelas1 = null;
        //     $kelas2 = null;

        //     foreach ($tingkatList as $tingkat) {
        //         if ($indexKelas[$tingkat] < count($kelasArrays[$tingkat])) {
        //             if (!$kelas1) {
        //                 $kelas1 = $tingkat;
        //             } elseif (!$kelas2) {
        //                 $kelas2 = $tingkat;
        //                 break;
        //             }
        //         }
        //     }

        //     if (!$kelas1 || !$kelas2) {
        //         break; // gak cukup siswa untuk bikin pasangan baru
        //     }

        //     $siswa1 = $kelasArrays[$kelas1][$indexKelas[$kelas1]++];
        //     $siswa2 = $kelasArrays[$kelas2][$indexKelas[$kelas2]++];

        //     $pasangan[] = [$siswa1, $siswa2];
        // }

        // // 6️⃣ Bagi pasangan ke dalam grup/ruang
        // $grupPasangan = array_chunk($pasangan, $pasanganPerGrup);

        // // 7️⃣ Tampilkan hasilnya di terminal
        // foreach ($grupPasangan as $indexGrup => $grup) {
        //     echo "=====================\n";
        //     echo "🧩 Grup / Ruang " . ($indexGrup + 1) . "\n";
        //     echo "=====================\n";

        //     foreach ($grup as $indexPasangan => $pair) {
        //         $data1 = $pair[0];
        //         $data2 = $pair[1];
        //         echo "Pasangan " . str_pad($indexPasangan + 1, 2, '0', STR_PAD_LEFT) . ": ";
        //         echo "{$data1['nis']} - {$data1['nama_siswa']} (Kelas {$data1['tingkat_id']})  &  ";
        //         echo "{$data2['nis']} - {$data2['nama_siswa']} (Kelas {$data2['tingkat_id']})\n";
        //     }

        //     echo "\n";
        // }

        // Perangkat/Test/jmlahruangan/
        // $ruang = 4; // misalnya mau dibagi jadi 4 ruang
        // $hasil = bagiKeRuang($ruang);

        // foreach ($hasil as $indexRuang => $grup) {
        //     echo "\n=====================\n";
        //     echo "🧩 Ruang " . ($indexRuang + 1) . "\n";
        //     echo "=====================\n";

        //     foreach ($grup as $indexPasangan => $pair) {
        //         $data1 = $pair[0];
        //         $data2 = $pair[1] ?? null; // kalau gak ada, kasih null

        //         echo "Pasangan " . str_pad($indexPasangan + 1, 2, '0', STR_PAD_LEFT) . ":";

        //         // tampilkan siswa pertama
        //         echo "  {$data1['nis']} - {$data1['nama_siswa']} (Kelas {$data1['kelas']['kelas']})";

        //         if ($data2) {
        //             // kalau ada pasangan kedua
        //             echo "  &  {$data2['nis']} - {$data2['nama_siswa']} (Kelas {$data2['kelas']['kelas']})";
        //         } else {
        //             // kalau gak ada pasangan kedua
        //             echo "  &  — (tidak ada pasangan)";
        //         }

        //         echo "\n";
        //     }

        //     echo "\n";
        // }
        // // Versi lain
        $hasil = bagiKelompokAB(16);

        foreach ($hasil as $indexRuang => $grup) {
            $RuangTest = $indexRuang + 1;
            echo "\n=====================\n";
            echo "🧩 Ruang " . ($RuangTest) . "\n";
            echo "=====================\n";

            foreach ($grup as $indexPasangan => $pair) {
                $data1 = $pair[0];
                $data2 = $pair[1] ?? null;

                echo "Pasangan " . str_pad($indexPasangan + 1, 2, '0', STR_PAD_LEFT) . ":";

                if ($data1) {
                    // echo "  {$data1['nis']} - {$data1['nama_siswa']} (Kelas {$data1['kelas']['kelas']})";
                    // echo "  {$data1['nis']} - {$data1['nama_siswa']} (Kelas {$data1['kelas']['kelas']}) [Tingkat {$data1['tingkat']}/Index {$data1['index_tingkat']}]/STS/2025/II/{$RuangTest}";
                    echo "  {$data1['nama_siswa']} (Kelas {$data1['kelas']['kelas']})}";
                } else {
                    echo "  — (kosong)";
                }

                if ($data2) {
                    echo " {$data2['nama_siswa']} (Kelas {$data2['kelas']['kelas']}) ";
                } else {
                    echo "  &  — (tidak ada pasangan)";
                }

                echo "\n";
            }

            echo "\n";
        }

        // Perangkat Test / Kurikulum / nama test / Ruang#Siswa / Jumlah Ruang / Cetak
        $Identitas = getIdentitas();
        $message = 'Perangkat Test / Kurikulum / PTS / 2025-9-11';
        $pesan = explode('/', $message); // Memecah Array yang yang telah diterima, lanjut fungsi loop fetch
        $tanggal = Carbon::create($pesan[3])->translatedformat('d F Y');
        // dd($tanggal);
        $sessions = config('whatsappSession.IdWaUtama');
        if (!config('whatsappSession.WhatsappDev')) {
            //$NoTujuan = $siswa->no_hp;
            //$NoTujuan = getNoTujuanOrtu($siswa);
            $NoTujuan = config('whatsappSession.wakaKurikulum');
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        //    Daftar Peserta Test
        $hasil = bagiKelompokAB(15);
        $dataTambahan = [
            'hasil' => $hasil,
            'nama_test' => $pesan[2],
            'bulan' => date('m'),
            'tahun' => date('Y'),
        ];

        $folder = public_path('temp/perangkat-test');
        /*
                php artisan make:view role.waka.kurikulum.Perangkat.wa-kartu-test
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-dh
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-ba
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-ba
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-no-meja
                php artisan make:view role.waka.kurikulum.Perangkat.wa-test-no-ruangan

                */
        $view = 'role.waka.kurikulum.Perangkat.wa-peserta-test';
        $filename = 'peserta-test';
        // DomExport($filename, $dataTambahan, $view, $folder);

        // Kartu Test

        // Kumpulan kartu hasil render
        $kartuList = [];


        foreach ($hasil as $indexRuang => $grup) {
            $namaRuang = 'Ruang ' . ($indexRuang + 1);
            $romawiRuang = angka_romawi($indexRuang + 1);
            foreach ($grup as $pasangan) {
                foreach ($pasangan as $siswa) {
                    if (!$siswa) continue;

                    $foto = $siswa['foto']
                        ? 'foto/' . $siswa['foto']
                        : 'img/dafault/blanko-foto.png';

                    $kelas = $siswa['kelas']['kelas'] ?? '-';

                    // 🔢 no_test sesuai format yang Bro minta
                    $no_test = str_pad($siswa['index_tingkat'], 3, '0', STR_PAD_LEFT)
                        . '/R' . $romawiRuang
                        . '/' . $kelas
                        . '/' . $dataTambahan['nama_test']
                        . '/' . $dataTambahan['bulan']
                        . '/' . $dataTambahan['tahun'];
                    $nama_siswa = strtoupper($siswa['nama_siswa']);
                    $text = " {$Identitas->namasek}\n{$dataTambahan['nama_test']}\n{$nama_siswa}\n{$kelas}\n{$no_test}";
                    $qrttd = qrttd($text, 300);
                    // 🧩 data untuk SVG
                    $data = [
                        'nama_siswa' => strtoupper($siswa['nama_siswa']),
                        'nama_sekolah' => strtoupper($Identitas->namasek),
                        'nama_kepala' => strtoupper($Identitas->namakepala),
                        'nis' => strtoupper($siswa['nis']),
                        'kelas' => $kelas,
                        'ruang' => $namaRuang,
                        'no_test' => $no_test,
                        'nama_test' => $dataTambahan['nama_test'],
                        'bulan' => $dataTambahan['bulan'],
                        'tahun' => $dataTambahan['tahun'],
                        'logo' => public_path('img/logo/logo.png'),
                        'stempel' => public_path('img/template/ttd/stempel.png'),
                        'ttd' => public_path('img/template/ttd/kepala.png'),
                        'qrttd' => $qrttd,
                        'nip_kepala' => $Identitas->nip_kepala ?? '-',
                        'penanggalan' => $Identitas->kecamatan . ", " . $tanggal,
                        'alamat_sekolah' => $Identitas->alamat,
                    ];

                    // 🔄 Subfolder dinamis berdasarkan jenis perangkat
                    $subFolder = 'perangkat-test/kartu';

                    // 🧠 Render SVG ke file dan dapatkan URL-nya
                    $svgUrl = render_svg_dynamic('kartu_test_1', $data, 'img/template/kartu_test', $subFolder);
                    // Convert ke PNG pakai ImageMagick
                    $pngDir = public_path('temp/perangkat-test/kartu/png');
                    if (!File::exists($pngDir)) {
                        File::makeDirectory($pngDir, 0755, true);
                    }

                    $tempSvg = public_path("temp/perangkat-test/kartu/{$siswa['nis']}.svg");
                    $outputPng = "$pngDir/{$siswa['nis']}.png";

                    $magick = '"C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe"';
                    $command = "$magick -density 300 \"$tempSvg\" -background white -flatten -resize 1004x650 -quality 100 \"$outputPng\"";

                    exec($command . ' 2>&1', $output, $result);
                    echo implode("\n", $output);
                    if ($result !== 0) {
                        echo "Error konversi: $result\n";
                    } else {
                        echo "PNG tersimpan: $outputPng\n";
                    }
                }
            }
        }


        // Folder PNG dan PDF
        $pngFolder = public_path('temp/perangkat-test/kartu/png');
        $pdfFolder = public_path('temp/perangkat-test/pdf');

        if (!File::exists($pdfFolder)) {
            File::makeDirectory($pdfFolder, 0777, true, true);
        }

        $pngFiles = File::files($pngFolder);
        if (empty($pngFiles)) {
            $this->info("❌ Tidak ada file PNG ditemukan di: $pngFolder");
            return Command::SUCCESS;
        }

        $pngList = [];
        foreach ($pngFiles as $file) {
            if (strtolower($file->getExtension()) === 'png') {
                $pngList[] = $file->getPathname();
            }
        }

        if (empty($pngList)) {
            $this->info('❌ Tidak ada file PNG valid.');
            return Command::SUCCESS;
        }

        $this->info("✅ Ditemukan " . count($pngList) . " file PNG.");

        $batch = [];
        $pdfIndex = 1;
        $perPdf = 8;

        foreach ($pngList as $i => $pngPath) {
            $nama = pathinfo($pngPath, PATHINFO_FILENAME);
            $batch[] = [
                'svg' => $pngPath,
                'nama_siswa' => $nama,
                'kelas' => '-',
                'ruang' => '-',
            ];

            if (count($batch) == $perPdf || $i == count($pngList) - 1) {
                $filename = "kartu-test-{$pdfIndex}.pdf";
                $filepath = $pdfFolder . '/' . $filename;
                $dataView = ['kartuList' => $batch];

                try {
                    Pdf::loadView('role.waka.kurikulum.Perangkat.wa-kartu-test', $dataView)
                        ->setPaper([0, 0, 612, 396])
                        ->save($filepath);
                    $this->info("✅ PDF tersimpan: $filename");
                } catch (\Exception $e) {
                    $this->error("❌ Gagal buat $filename: " . $e->getMessage());
                }

                $batch = [];
                $pdfIndex++;
            }
        }

        $this->info("Selesai ✔");
        return Command::SUCCESS;
    }
}
// siakad:cobabuat
