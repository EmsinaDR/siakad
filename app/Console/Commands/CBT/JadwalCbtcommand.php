<?php

namespace App\Console\Commands\CBT;

use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class JadwalCbtcommand extends Command
{
    protected $signature = 'siakad:JadwalCbtcommand';
    protected $description = 'Pengingat test pada sistem jadwal test cbt';

    /*
        |--------------------------------------------------------------------------
        | 📌 CBTJadwal
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
        $this->info("Command 'JadwalCbtcommand' berhasil dijalankan.");
    }
}