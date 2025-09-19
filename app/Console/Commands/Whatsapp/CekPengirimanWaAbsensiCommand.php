<?php

namespace App\Console\Commands\Whatsapp;

use App\Models\Absensi\Eabsen;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Console\Command;

class CekPengirimanWaAbsensiCommand extends Command
{
    protected $signature = 'whatsapp:cek-wa-absensi-null';
    protected $description = 'Mengirim wa permberitahuan absensi yang belum terkirim hari ini';

    public function handle()
    {
        $CekWaAbsensi = Eabsen::whereNull('whatsapp_response')->whereDate('created_at', now())->get();

        foreach ($CekWaAbsensi as $kirimWa) {
            $siswa = Detailsiswa::find($kirimWa->detailsiswa_id);
            if (!config('whatsappSession.WhatsappDev')) {
                //$sessions = getWaSession($siswa->tingkat_id); // by tingkat ada di dalamnya
                //$sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = getNoTujuanOrtu($siswa);
                // $NoTujuan = $siswa->no_hp;
            } else {
                $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            $data = [
                'jenisAbsen' => $kirimWa->jenisAbsen,
                'telat' => number_format($kirimWa->telatMenit, 0),
                'waktu' => $kirimWa->jenisAbsen === 'masuk' ? 'Pagi' : 'Siang',
                'tanggal' => $kirimWa->created_at,
                'pulang_cepat'   => $kirimWa->pulang_cepat,
                'pulang_telat'   => $kirimWa->pulang_telat,
            ];
            // $ResponWa = kirimPesanAbsensi($siswa->id, $data);
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, PesanAbsensi($siswa->id));
            // langsung update field whatsapp_response
            Eabsen::where('id', $kirimWa->id)->update([
                'whatsapp_response' => $result['status'] ?? null,
            ]);
        }
        $this->info("Command 'CekPengirimanWaAbsensiCommand' berhasil dijalankan.");
    }
}
