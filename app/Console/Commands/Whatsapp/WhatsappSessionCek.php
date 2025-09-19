<?php

namespace App\Console\Commands\Whatsapp;

use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class WhatsappSessionCek extends Command
{
    protected $signature = 'siakad:KirimSesiWhatsapp';
    protected $description = 'Mengecek Sesi Whatsapp setiap satu jam sekali dan jalankan jika sesi tidak aktif, jika aktif abaikan';

    /*
        |--------------------------------------------------------------------------
        | 📌 WhatsappSession
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | -
        |
        | Tujuan :
        | - Agar whatsapp stabil dalam digunakan cek sesi untuk menghindari sesi whatsapp mati!
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
        $this->info("Command 'KirimSesiWhatsapp' berhasil dijalankan.");
    }
}
