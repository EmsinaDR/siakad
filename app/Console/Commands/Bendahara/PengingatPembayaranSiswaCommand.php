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
    protected $description = 'Pengingat pembayaran siswa / Syahriah / SPP / Komite';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $Identitas = Identitas::first();
        if (!config('whatsappSession.WhatsappDev')) {
            $Siswas = Detailsiswa::SiswaAktif()->whereNotNull('kelas_id')->get();
        } else {
            $Siswas = Detailsiswa::SiswaAktif()->whereIn('tingkat_id', [7])->whereNotNull('kelas_id')->limit(5)->get();
            // $Siswas = Detailsiswa::SiswaAktif()->whereIn('tingkat_id', [8])->whereNotNull('kelas_id')->limit(5)->get();
            // $Siswas = Detailsiswa::SiswaAktif()->whereIn('tingkat_id', [9])->whereNotNull('kelas_id')->limit(5)->get();
            // $Siswas = Detailsiswa::SiswaAktif()->whereIn('tingkat_id', [7, 8, 9])->whereNotNull('kelas_id')->limit(5)->get();
        }
        // echo 'bekerja';
        // $result = \App\Models\Whatsapp\WhatsApp::sendMessage('Siswa', '6285329860005', '$PesanKirim');
        foreach ($Siswas as $Siswa) {
            $sessions = config('whatsappSession.IdWaUtama');
            if (!config('whatsappSession.WhatsappDev')) {
                $NoTujuan = getNoTujuanOrtu($Siswa);
            } else {
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            $pesanKiriman = PesanPembayaran($Siswa->id);
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $pesanKiriman);
            sleep(rand(5, 20));
        }
    }
}
