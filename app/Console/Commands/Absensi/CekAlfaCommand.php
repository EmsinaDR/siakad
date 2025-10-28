<?php

namespace App\Console\Commands\Absensi;

use App\Models\Absensi\Eabsen;
use Illuminate\Console\Command;

class CekAlfaCommand extends Command
{
    protected $signature = 'absensi:cek-alfa';
    protected $description = 'Mengecek Alfa';

    public function handle()
    {
        $eabsens = Eabsen::with('detailsiswa.KelasOne')->where('absen', 'alfa')->whereDate('created_at', now())->get();
        $pesan = "Daftar Siswa Alfa Hari ini\n";
        foreach ($eabsens as $index => $absen) {
            $pesan .= $index + 1 . "." . $absen->detailsiswa->nama_siswa . "/" . $absen->detailsiswa->KelasOne->kelas . "\n";
        }
        $sessions = config('whatsappSession.IdWaUtama');
        $NoTujuan = config('whatsappSession.NoKepala');
        // $NoTujuan = config('whatsappSession.DevNomorTujuan');
        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Informasi Daftar Siswa Alfa', $pesan));
        // $NoTujuan
        $this->info("Command 'CekAlfaCommand' berhasil dijalankan.\n{$pesan}");
    }
}
