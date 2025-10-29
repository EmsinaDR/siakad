<?php

namespace App\Console\Commands\Absensi;

use Carbon\Carbon;
use App\Models\GuruPiket;
use App\Models\Absensi\Eabsen;
use Illuminate\Console\Command;
use App\Models\Walkes\JadwalPiket;
use App\Models\User\Siswa\Detailsiswa;

class GuruPiketCommand extends Command
{
    protected $signature = 'absensi:guru-piket';
    protected $description = 'Data guru piket sebagai pengingat absensi';

    public function handle()
    {
        // $senin =
        $hari = ucfirst(strtolower(Carbon::now()->locale('id')->isoFormat('dddd')));

        $guruPiket = GuruPiket::with('guru')->where('hari', $hari)->get();

        $eabsen = Eabsen::with('EabsentoDetailsiswa')
            ->whereDate('created_at', now())
            ->pluck('detailsiswa_id');

        $siswaTidakAbsen = Detailsiswa::with('kelasOne')
            ->whereNotIn('id', $eabsen)
            ->get()
            ->groupBy(fn($siswa) => $siswa->kelasOne->kelas ?? 'Tidak Ada Kelas');

        $namaSiswa = '';

        foreach ($siswaTidakAbsen as $kelas => $daftarSiswa) {
            $namaSiswa .= "🏫 *Kelas {$kelas}*\n";

            foreach ($daftarSiswa as $siswa) {
                $namaSiswa .= "- {$siswa->nama_siswa}\n";
            }

            $namaSiswa .= "\n"; // spasi antar kelas
        }

        foreach ($guruPiket as $piket):
            $PesanIkiramn =
                "Mohon Bapak / Ibu {$piket->guru->nama_guru} membantu kontrol siswa hari ini yang belum melakukan absensi digital dikelas sebelum pukul 08:30 WIB bersama guru di jam pelajaran pertama\n" .
                "Berikut Informasi Daftar Nama Siswa :\n" .
                "{$namaSiswa}\n" .
                "Kami sampaikan banyak Terima Kasih atas partisipasi dan kerjasamanya.\n";
            $sessions = config('whatsappSession.IdWaUtama');
            if (!config('whatsappSession.WhatsappDev')) {
                $NoTujuan = $piket->guru->no_hp;
            } else {
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }

            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, format_pesan('Informasi Guru Piket', $PesanIkiramn));
            $this->info("{$PesanIkiramn}");
            $this->info("Command 'Guru Piket Hari {$PesanIkiramn}' berhasil dijalankan. Data: ");
        endforeach;
    }
}
