<?php
// app/Console/Commands/KirimJadwalWhatsapp.php
namespace App\Console\Commands\Whatsapp;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Console\Command;
use App\Models\Whatsapp\PenjadwalanPesan;
// Daftarkan di ScheduleServiceProvider schedule untuk run setiap menit
//php artisan schedule:work

class PenjadwalanPesanCommand extends Command
{
    /**
     * 📌 Catatan: Kirim Jadwal Whatsapp
     *
     * Deskripsi:
     * - Mengirim laporan absensi ke wali kelas khusus siswa.
     * - Laporan absensi guru ke kepala sekolah :
     * -
     * -
     *
     * Tujuan:
     * Mengingatkan guru tentang jadwal rapat agar tidak terlewat.
     */

    protected $signature = 'wa:PenjadwalanPesan';
    protected $description = 'Kirim pesan WhatsApp terjadwal';

    public function handle()
    {

        //  PenjadwalanPesan::update([
        //             'status' => 'pending',
        //         ]);

        $now = Carbon::now();

        $jadwals = PenjadwalanPesan::where('scheduled_at', '<=', $now)
            ->where('status', 'pending')
            ->get();
        $sessions = config('whatsappSession.IdWaUtama');
        // $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, '6285329860005', 'coba');
        // $result = \App\Models\Whatsapp\WhatsApp::sendMessage('GuruId', '6285329860005', 'Gagal Kirim');
        foreach ($jadwals as $jadwal) {
            $nomors = [];

            if ($jadwal->tipe_tujuan == 'nomor') {
                $nomors = [$jadwal->tujuan_nomor]; // langsung inisialisasi array
                $sessions = config('whatsappSession.IdWaUtama');
                $pesan = cleanPesanWA($jadwal->pesan);
                $jumlah = 0;

                foreach ($nomors as $no) {
                    if ($jadwal->gambar) {
                        $filePath = base_path('whatsapp/uploads/' . $jadwal->gambar); // dinamis
                        // $filePath = base_path('whatsapp/uploads/1753780173-Ata Dev CS.png'); // dinamis
                        $pesankiriman = format_pesan_gb('Jadwal Pesan', $pesan);
                        $hasil = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $no, $pesankiriman, $filePath);
                        // $hasil = \App\Models\Whatsapp\WhatsApp::sendMedia(config('whatsappSession.IdWaUtama');, ['6285329860005', '6285329860005'], base_path('whatsapp/uploads/test.png'),'Coba kirim media!');
                        // $respons = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $no, $filePath, $pesan);

                        // $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $no, $pesan.'path'.$filePath);
                    } else {
                        $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $no, $pesan);
                    }

                    $jumlah++;
                    sleep(rand(3, 10));
                }

                $jadwal->update([
                    'status' => 'sent',
                    'response' => "Terkirim ke {$jumlah} nomor",
                ]);
            } elseif ($jadwal->tipe_tujuan == 'guru') {
                // Id Guru = $jadwal->tujuan
                $Guru = Detailguru::whereIn('id', json_decode($jadwal->tujuan))->get();
                $nomors = $Guru->pluck('no_hp')->filter()->toArray();
                foreach ($nomors as $no) {
                    $sessions = config('whatsappSession.IdWaUtama');
                    $pesan = cleanPesanWA($jadwal->pesan);
                    $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $no, $pesan);
                    $jadwal->update([
                        'status' => 'sent',
                        'response' => 'Terkirim ke ' . count($nomors) . ' nomor',
                    ]);
                    sleep(rand(3, 10));
                }
            } elseif ($jadwal->tipe_tujuan == 'kelas') {
                // $jadwal->tujuan berubah jadi id kelas dalam array
                $siswas = Detailsiswa::whereIn('kelas_id', json_decode($jadwal->tujuan))->whereNotNull('nohp_siswa')->get();
                foreach ($siswas as $siswa) {
                    $sessionwa = getWaSessionByTingkat($siswa->tingkat_id);
                    $nomors = $siswa->nohp_siswa;
                    $pesan = cleanPesanWA($jadwal->pesan);
                    $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessionwa, $nomors, $pesan);
                    sleep(rand(3, 10));
                }
                $jadwal->update([
                    'status' => 'sent',
                    'response' => 'Terkirim ke daftar kirim',
                ]);
            } elseif ($jadwal->tipe_tujuan == 'tingkat') {
                // $jadwal->tujuan berubah jadi id kelas dalam array
                $siswas = Detailsiswa::whereIn('tingkat_id', json_decode($jadwal->tujuan))->get();
                foreach ($siswas as $siswa) {
                    $sessionwa = getWaSessionByTingkat($siswa->tingkat_id);
                    $nomors = $siswa->nohp_siswa;
                    $pesan = cleanPesanWA($jadwal->pesan);
                    $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessionwa, $nomors, $pesan);
                    sleep(rand(3, 10));
                }
                $jadwal->update([
                    'status' => 'sent',
                    'response' => 'Terkirim ke daftar nomor',
                ]);
            } elseif ($jadwal->tipe_tujuan == 'seluruh siswa') {
                // $jadwal->tujuan berubah jadi id kelas dalam array
                $siswas = Detailsiswa::get();
                foreach ($siswas as $siswa) {
                    $sessionwa = getWaSessionByTingkat($siswa->tingkat_id);
                    $nomors = $siswa->nohp_siswa;
                    $pesan = cleanPesanWA($jadwal->pesan);
                    $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessionwa, $nomors, $pesan);
                    sleep(rand(3, 10));
                }
                $jadwal->update([
                    'status' => 'sent',
                    'response' => 'Terkirim ke daftar nomor',
                ]);
            } elseif ($jadwal->tipe_tujuan == 'siswa') {
                // $jadwal->tujuan berubah jadi id kelas dalam array
                $siswas = Detailsiswa::whereIn('id', json_decode($jadwal->tujuan))->get();
                foreach ($siswas as $siswa) {
                    $sessionwa = getWaSessionByTingkat($siswa->tingkat_id);
                    $nomors = $siswa->nohp_siswa;
                    $pesan = cleanPesanWA($jadwal->pesan);
                    $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessionwa, $nomors, $pesan);
                    sleep(rand(3, 10));
                }
                $jadwal->update([
                    'status' => 'sent',
                    'response' => 'Terkirim ke daftar nomor',
                ]);
            }
        }
        HapusCacheDenganTag('PenjadlwalanPesan');

        return 0;
    }
}
// foreach ($jadwals as $jadwal) {
//     $nomors = [];

//     if ($jadwal->tipe_tujuan == 'nomor') {
//         $nomors[] = $jadwal->tujuan_nomor;
//         foreach ($nomors as $no) {
//             $sessions = config('whatsappSession.IdWaUtama');
//             $pesan = cleanPesanWA($jadwal->pesan);
//             $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $no, $pesan);
//             sleep(rand(3, 10));
//         }

//         $jadwal->update([
//             'status' => 'sent',
//             'response' => 'Terkirim ke ' . count($nomors) . ' nomor',
//         ]);
//     } elseif ($jadwal->tipe_tujuan == 'kelas') {
//         $siswa = Detailsiswa::where('kelas_id', $jadwal->tujuan)->get();
//         $nomors = $siswa->pluck('no_hp')->filter()->toArray();

//         foreach ($nomors as $no) {
//             $sessions = config('whatsappSession.IdWaUtama');
//             $pesan = cleanPesanWA($jadwal->pesan);
//             $respons = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $no, $pesan);
//         }
//         $jadwal->update([
//             'status' => 'sent',
//             'response' => 'Terkirim ke ' . count($nomors) . ' nomor',
//         ]);
//         sleep(rand(3, 10));
//     }
// }