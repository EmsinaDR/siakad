<?php

namespace App\Console\Commands\Bendahara\Tabungan;

use App\Models\Whatsapp\WhatsApp;
use App\Models\Admin\Identitas;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class TabunganSiswaCommand extends Command
{
    protected $signature = 'tabungan:tabungan-siswa';
    protected $description = 'Data tabungan siswa';

    /*
        |--------------------------------------------------------------------------
        | 📌 Tabungansiswa
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
        $Identitas = Identitas::first();
        if (!config('whatsappSession.WhatsappDev')) {
            $Siswas = getSiswaAktif();
        } else {
            $Siswas = getSiswaAktif([], 5); // gunakan parameter limit
        }

        foreach ($Siswas as $Siswa) {
            $sessions = config('whatsappSession.IdWaUtama');
            if (!config('whatsappSession.WhatsappDev')) {
                //$sessions = getWaSessionByTingkat($Siswa->tingkat_id);
                //$sessions = config('whatsappSession.IdWaUtama');
                // $NoTujuan = $Siswa->no_hp;
            } else {
                $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            $pesanKiriman = format_pesan('Data Tabungan', tabungan_siswa($Siswa->id));
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $pesanKiriman);
            sleep(rand(2, 10));
        }
        $this->info("Command 'TabunganSiswaCommand' berhasil dijalankan.");
    }
}
