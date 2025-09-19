<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class CekRegistrasiCommand extends Command
{
    protected $signature = 'system:cek-registrasi';
    protected $description = 'Pengecekan Registrasi';

    public function handle()
    {
        $Identitas = getIdentitas();
        $selisih = cek_hitung_selisih($Identitas->trial_ends_at);
        $Hari = (int) $selisih['hari'] - 362 * (-1); // bisa negatif jika sudah lewat

        if ($Hari >= 0 && $Hari <= 4) {
            // sisa 4 hari terakhir sampai 0
            $kurang = 'oke';
            $this->KirimInformasi($Hari);
        } elseif ($Hari < 0) {
            // sudah lewat
            $kurang = 'Jalankan Command';
            $this->KirimInformasi($Hari);
        } else {
            // masih >4 hari
            $kurang = 'normal';
        }
    }
    protected function KirimInformasi($Hari)
    {
        //dd($request->all());
        $sessions = config('whatsappSession.IdWaUtama');
        if (!config('whatsappSession.WhatsappDev')) {
            // $sessions = getWaSession($siswa->tingkat_id); // by tingkat ada di dalamnya
            $sessions = config('whatsappSession.SekolahNoTujuan');
            //$NoTujuan = getNoTujuanOrtu($siswa)
            // $NoTujuan = $siswa->no_hp;
        } else {
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        $vendor = config('whatsappSession.vendor');
        $PesanKirim =
            "Di informasikan bahwa registrasi tinggal {$Hari} Hari lagi\n" .
            "Mohon persiapkan perpanjangan Kerjasam dengan {$vendor}\n" .
            "\n";
        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Informasi Registrasi', $PesanKirim));
    }
}
