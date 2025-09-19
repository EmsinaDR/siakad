<?php

namespace App\Console\Commands\Absensi;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Absensi\EabsenGuru;

class LaporanAbsensiGuruCommand extends Command
{
    protected $signature = 'laporan:absensi-guru';
    protected $description = 'Laporan absensi harian dan bulanan guru ke kepala sekolah';

    public function handle()
    {
        $pesan = laporan_absensi_guru();
        $catatan =
            "*Catatan* \n" .
            "*Format Baca* : \nKode Guru / Waktu Absensi / Selisih \n" .
            "*Waktu absen* \t\t\t: 07:00 WIB \n" .
            "*Toleransi* \t\t\t\t\t: 5 Menit";
        // $pesan .= "{$AbsGuru->guru->nama_guru} : {$waktu} / {$AbsGuru->telat}\n";
        // // $JumlahHadir;

        $sessions = config('whatsappSession.IdWaUtama');
        if (!config('whatsappSession.WhatsappDev')) {
            $NoTujuan = config('whatsappSession.NoKepala');
        } else {
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        $PesanKirim =
            "Berikut ini informasi laporan kehadiran guru : \n" .
            "{$pesan} \n" .
            "{$catatan} \n" .
            "\n";

        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Laporan Absensi Guru', $PesanKirim));

        // $this->info("Command 'LaporanAbsensiGuruCommand' berhasil dijalankan.\n {$pesan}");
    }
}
