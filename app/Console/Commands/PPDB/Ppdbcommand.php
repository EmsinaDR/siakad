<?php

namespace App\Console\Commands\PPDB;

use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class Ppdbcommand extends Command
{
    protected $signature = 'siakad:Ppdbcommand';
    protected $description = 'Data PPDB siswa baru';

    /*
        |--------------------------------------------------------------------------
        | 📌 PPDB Siswa
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
        $this->info("Command 'Ppdbcommand' berhasil dijalankan.");
    }
}