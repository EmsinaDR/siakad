<?php

namespace App\Console\Commands\Whatsapp;

use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class ValidasiNoHPCommand extends Command
{
    protected $signature = 'whatsapp:validasi-nohp';
    protected $description = 'Cek validasi pernah chat no hp orang tua';

    public function handle()
    {
        $Siswas = Detailsiswa::with('kelas')->SiswaAktif()->limit(5)->get();

        $identitas = getIdentitas();
        $sessions = config('whatsappSession.IdWaUtama');
        foreach ($Siswas as $siswa):
            if (!config('whatsappSession.WhatsappDev')) {
                //$NoTujuan = $siswa->no_hp;
                //$NoTujuan = getNoTujuanOrtu($siswa);
                $NoTujuan = $siswa->ibu_nohp;
            } else {
                $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            $Carifilename = $siswa->nis . '-3x4.png';
            $copyFile = CopyDataSiswa($Carifilename, 'img/siswa/foto/');

            // Validasi hasil copy
            if (!isset($copyFile['status']) || $copyFile['status'] === 'error' || !file_exists(public_path('img/siswa/foto/' . $Carifilename))) {
                // Fallback otomatis
                $filename = 'blanko-foto.png';
                $sourcePath = public_path('img/default/' . $filename);
            } else {
                $filename = $copyFile['file'];
                $sourcePath = public_path('img/siswa/foto/' . $filename);
            }
            $caption =
                "Mohon maaf mengganggu, kami ingin memvalidasi no HP orang tua untuk menghindari pembatasan penggunaan whatsapp, agar tetap mendapatkan informasi ananda {$siswa->nama_siswa} disekolah. Bapak / Ibu bisa menjawab pertanyaan ini \n" .
                "Apakah benar ini No HP dari orang tua {$siswa->nama_siswa} yang bersekolah di {$identitas->namasek}?\n" .
                "Untuk Data Ananda {$siswa->nama_siswa} :\n" .
                "Nama : {$siswa->nama_siswa}\n" .
                "Kelas : {$siswa->kelas->kelas}\n" .
                "Nis : {$siswa->nis}\n" .
                "\n\n" .
                "Mohon jawab dan balas pesan ini dengan mengetikkan\n" .
                "Jika Benar : Validasi/Ortu/Benar/{$siswa->nis}\n" .
                "Jika Salah : Validasi/Ortu/Salah/{$siswa->nis}\n" .
                "Jika ada kesalahan segera konfirmasi.\n" .
                "\n\n";
            // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Validasi No HP Orang Tua', $PesanKirim));
            $filePath = base_path('whatsapp/uploads/' . $filename);
            $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoTujuan, format_pesan_gb('Validasi No HP Orang Tua', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
            $this->info("Isi \n{$caption} - {$NoTujuan}");
        endforeach;
        // $this->info("Command 'ValidasiNoHPCommand' berhasil dijalankan.");
    }
}
