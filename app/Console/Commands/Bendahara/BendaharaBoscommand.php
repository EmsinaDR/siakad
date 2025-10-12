<?php

namespace App\Console\Commands\Bendahara;

use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class BendaharaBoscommand extends Command
{
    protected $signature = 'siakad:BendaharaBoscommand';
    protected $description = 'Informasi keuangan BOS';

    /*
        |--------------------------------------------------------------------------
        | 📌 BendaharaBos
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
        $this->info("Command 'BendaharaBoscommand' berhasil dijalankan.");
    }
}