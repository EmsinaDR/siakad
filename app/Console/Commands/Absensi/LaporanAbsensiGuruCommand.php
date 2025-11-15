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
        $pesan = laporan_absensi_guru(); //'2025-09-19'
        // $pesan = laporan_absensi_guru('2025-09-19');
        // $pesan = json_encode(getAbsensiPivot('2025-09', 'AS'));
        // $dataTambahan = [
        //     'variabel' => 'xxxx'
        // ];
        // $folder = public_path('namafolder');
        // $view = 'fileview'; // Contoh = role.program.surat.siswa.surat-pindah-sekolah
        // $filename = 'namafile';
        // DomExport($filename, $dataTambahan, $view, $folder);
        // // $pesan .= "{$AbsGuru->guru->nama_guru} : {$waktu} / {$AbsGuru->telat}\n";
        // // // $JumlahHadir;

        $sessions = config('whatsappSession.IdWaUtama');
        if (!config('whatsappSession.WhatsappDev')) {
            $NoTujuan = config('whatsappSession.NoKepala');
        } else {
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }
        $PesanKirim =
            "{$pesan} \n" .
            "\n";

        // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, '6285329860005', format_pesan('Laporan Absensi Guru', $PesanKirim));
        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Laporan Absensi Guru', $PesanKirim));

        // $this->info("Command 'LaporanAbsensiGuruCommand' berhasil dijalankan.\n {$pesan}");
    }
}
