<?php

namespace App\Console\Commands\System;

use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\File;

class BersihkanTemp extends Command
{
    protected $signature = 'siakad:BersihkanTemp';
    protected $description = 'Temp Clear';

    /*
        |--------------------------------------------------------------------------
        | 📌 Mempersihkan File Sampah
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - Membersihkan file generate sementara
        |
        | Tujuan :
        | - Bersihkan Temp di public dan Upload Whatsapp
        | -
        |
        |
        | Penggunaan :
        | - Jelaskan penggunaannya dimana atau hubungannya
        | -
        |
        |
        |
    */

    public function handle()
    {
        // Tuliskan logika command di sini

        if (is_day('sabtu')) {
            $HapusPublicTemp = HapusFile('temp'); // public/temp
            $HapusWhatsapp = HapusFolder('whatsapp/uploads'); // Whatsapp/Uploads
            $this->info("Command 'BersihkanTemp' berhasil dijalankan.");
        } else {
            $this->info("Command tidak dijalakna di hari ini.");
        }

        // $namaFile = 'sertifikat'; //sertifikat.pdf
        // $pdf_to_jpg = pdf_to_image_wa($namaFile); // => 'abc123'

        // //fileinjec.pdf
        // $namaFile = 'fileinjec';
        // $hasil = CopyFileWa($namaFile . '.pdf');
        // $pdf_to_jpg = pdf_to_image_wa($namaFile); // => 'abc123'
        // dd($hasil);
    }
}
