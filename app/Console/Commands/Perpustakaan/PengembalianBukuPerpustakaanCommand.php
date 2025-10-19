<?php

namespace App\Console\Commands\Perpustakaan;

use Carbon\Carbon;
use App\Models\Admin\Identitas;
use Illuminate\Console\Command;
use App\Models\Perpustakaan\Eperpuspeminjam;
use App\Models\User\Siswa\Detailsiswa;

class PengembalianBukuPerpustakaanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siakad:pengembalian-buku-perpustakaan';

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
        /*
            |--------------------------------------------------------------------------
            | 📌 Pengembalian Buku Perpustakaan :
            |--------------------------------------------------------------------------
            |
            | Fitur :
            | - Pengingat 1 Hari sebelumnya untuk siswa
            | - Pengingat untuk petugas
            |
            | Tujuan :
            | - Menata secara tertib administrasi buku
            |
            |
            | Penggunaan :
            | - xxxxxxxxxxx
            |
            */
        // Proses Coding
        $Identitas = Identitas::first();
        $besok = Carbon::now()->addDay(1);
        if (!config('whatsappSession.WhatsappDev')) {
            $DataPeminjaman = Eperpuspeminjam::whereDate('batas_pengembalian', $besok)->where('status', 'dipinjam')->get();
        } else {
            $DataPeminjaman = Eperpuspeminjam::whereDate('batas_pengembalian', $besok)->where('status', 'dipinjam')->limit(5)->get();
        }
        // loop untuk kirim pengingat
        foreach ($DataPeminjaman as $peminjaman) {
            $sessions = config('whatsappSession.IdWaUtama');
            if (!config('whatsappSession.WhatsappDev')) {
                $sessions = getWaSessionByTingkat($peminjaman->tingkat_id);
                $NoTujuan = $peminjaman->siswa->no_hp;
            } else {
                $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }
            // $pesanKiriman = PesanPembayaran($Siswa->id);
            $pesanKiriman = Perpustakaan_Pengembalian_Buku($peminjaman);
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $pesanKiriman);
            sleep(rand(2, 10));

            echo "Ingatkan siswa {$peminjaman->nama_siswa} untuk mengembalikan buku besok!\n";
        }
    }
}
