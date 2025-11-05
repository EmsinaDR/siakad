<?php

namespace App\Console\Commands\Rapat;

// use App\Models\Whatsapp\WhatsApp;

use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Absensi\Eabsen;
use App\Models\Admin\Identitas;
use Illuminate\Console\Command;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Http;
use App\Models\Program\Rapat\DataRapat;

class DataRapatCommand extends Command
{
    protected $signature = 'rapat:data-rapat';
    protected $description = 'Mengirim pesan WhatsApp sesuai jadwal';

    public function handle()
    {
        /**
         * 📌 Catatan: Pengingat Rapat
         *
         * Deskripsi:
         * - Mengirim pengingat rapat ke guru pada jam 7.30
         * // Pada ScheduleServiceProvider
         * $schedule->command('rapat:data-rapat')->dailyAt('07:30')->runInBackground();
         *
         * -
         * -
         *
         * Tujuan:
         * Mengingatkan guru tentang jadwal rapat agar tidak terlewat.
         */

        $Identitas = Identitas::first();
        $DataRapats = DataRapat::whereDate('tanggal_pelaksanaan', now()->toDateString())->get();

        if ($DataRapats->isEmpty()) {
            // Tidak ada rapat hari ini, stop proses
            return;  // atau lakukan sesuatu yang lain
        }
        if (!config('whatsappSession.WhatsappDev')) {
            $Gurus =  getGurus([1, 2, 3]);
        } else {
            $Gurus = getGurus([1, 2, 3], 5);
        }

        // dd($DataRapats);
        foreach ($DataRapats as $rapat) {
            foreach ($Gurus as $Guru) {
                $Sapaan = ($Guru->jenis_kelamin === 'Perempuan') ? 'Ibu' : 'Bapak';
                $sessions = config('whatsappSession.IdWaUtama');
                if (!config('whatsappSession.WhatsappDev')) {
                    // $NoTujuan = $Guru->no_hp;
                } else {
                    $NoTujuan = config('whatsappSession.DevNomorTujuan');
                }
                $hari = Carbon::create($rapat->tanggal_pelaksanaan)->translatedformat('l, d F Y');
                $pesanKiriman =
                    "==============================\n" .
                    "📌 *Data Agenda Rapat*\n" .
                    "==============================\n\n" .
                    "*Assalamualaikum Wr.Wb*\n" .
                    "{$Sapaan} {$Guru->nama_guru}, {$Guru->gelar}, kami sampaikan sebagai pengingat, jika pada hari ini ada agenda *{$rapat->nama_rapat}*.\n\n" .
                    "Rapat : {$rapat->nama_rapat}\n" .
                    "Tempat : {$rapat->tempat}\n" .
                    "Hari dan Tanggal : {$hari}\n\n" .
                    "Dimohon {$Sapaan} hadir dalam acara tersebut.\n" .
                    "Atas perhatian dan kesiapannya, kami sampaikan terima kasih.\n\n" .
                    "*Wassalamualaikum Wr.Wb*\n" .
                    "\n" . str_repeat("─", 25) . "\n" .
                    "✍️ Dikirim oleh:\n" .
                    "*Boot Assistant Pelayanan {$Identitas->namasek}*";
                $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $pesanKiriman);
                sleep(rand(2, 10));
            }
        }
    }
}
