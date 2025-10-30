<?php

namespace App\Console\Commands\CBT;

use Illuminate\Console\Command;

class JadwalPengingatUlanganCommand extends Command
{
    protected $signature = 'siakad:JadwalPengingatUlangan';
    protected $description = 'Jadwal_Pengingat';

    /*
        |--------------------------------------------------------------------------
        | 📌 CAT Siswa
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | -
        |
        | Tujuan :
        | - Jelaskan tujuan command ini
        | - Jadwal Pengingat ulangan yang ditujukan ke siswa dan orang  tua agar orang tua aktiv mengingatkan siswa belajar
        |
        |
        | Penggunaan :
        | - Jelaskan penggunaannya dimana atau hubungannya
        | -
        |
        ||
    */

    public function handle()
    {
        // Tuliskan logika command di sini
        $this->info("Command 'JadwalPengingatUlangan' berhasil dijalankan.");
    }
}
