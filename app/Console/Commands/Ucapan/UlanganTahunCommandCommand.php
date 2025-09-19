<?php

namespace App\Console\Commands\Ucapan;

use Illuminate\Console\Command;

class UlanganTahunCommandCommand extends Command
{
    protected $signature = 'ucapan:ulang-tahun-siswa';
    protected $description = 'Kirim ucapan ulang tahun siswa';

    public function handle()
    {
        $this->info("Command 'UlanganTahunCommandCommand' berhasil dijalankan.");
    }
}