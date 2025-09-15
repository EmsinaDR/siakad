<?php

namespace App\Console\Commands\Bendahara;

use App\Models\Admin\Identitas;
use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;

class PengingatPembayaranSiswaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siakad:pengingat-pembayaran-siswa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $Identitas = Identitas::first();
        if (!config('whatsappSession.WhatsappDev')) {
            $Siswas = Detailsiswa::whereNotNull('kelas_id')->get();
        } else {
            $Siswas = Detailsiswa::whereNotNull('kelas_id')->limit(5)->get();
        }

        foreach ($Siswas as $Siswa) {
            $sessions = config('whatsappSession.IdWaUtama');
            if (!config('whatsappSession.WhatsappDev')) {
                // $NoTujuan = $Guru->no_hp;
            } else {
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            $pesanKiriman = PesanPembayaran($Siswa->id);
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $pesanKiriman);
            sleep(rand(2, 10));
        }
    }
}
