<?php

namespace App\Console\Commands\Ekstra;

use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class Ekstracommand extends Command
{
    protected $signature = 'siakad:Ekstracommand';
    protected $description = 'Data ekstrakurikuler';

    /*
        |--------------------------------------------------------------------------
        | 📌 Ekstrakurikuler
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
        |
        |
    */

    public function handle()
    {
        // Tuliskan logika command di sini
        $this->info("Command 'Ekstracommand' berhasil dijalankan.");
    }
}