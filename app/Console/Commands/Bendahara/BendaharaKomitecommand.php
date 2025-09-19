<?php

namespace App\Console\Commands\Bendahara;

use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class BendaharaKomitecommand extends Command
{
    protected $signature = 'siakad:BendaharaKomitecommand';
    protected $description = 'Informasi keuangan Komite';

    /*
        |--------------------------------------------------------------------------
        | 📌 BendaharaKomite
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
        $this->info("Command 'BendaharaKomitecommand' berhasil dijalankan.");
    }
}