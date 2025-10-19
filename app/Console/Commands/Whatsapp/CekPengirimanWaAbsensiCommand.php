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
        $CekWaAbsensi = Eabsen::where(function ($query) {
            $query->whereNull('whatsapp_response')
                ->orWhere('whatsapp_response', 0)
                ->orWhere('whatsapp_response', 'error');
        })
            ->whereDate('created_at', now())
            ->get();

        foreach ($CekWaAbsensi as $kirimWa) {
            $siswa = Detailsiswa::find($kirimWa->detailsiswa_id);
            $nama = $kirimWa->detailsiswa->nama_siswa;
            $jam = \Carbon\Carbon::parse($kirimWa->created_at)->translatedFormat('H:i:s');
            $tanggal = \Carbon\Carbon::parse($kirimWa->created_at)->translatedFormat('l, d F Y');
            if (!config('whatsappSession.WhatsappDev')) {
                $sessions = getWaSession(); // by tingkat ada di dalamnya
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

            $isi =
                "Informasi untuk Bp / Ibu, kami sampaikan terkait dengan absensi kehadiran ananda {$nama} sebagai berikut : \n\n" .
                "📝 Nama\t\t: {$nama}\n" .
                "🏫 Kelas\t\t: {$siswa->kelas->kelas}\n" .
                "📅 Tanggal\t: {$tanggal}\n" .
                "⏰ Jam\t\t\t: {$jam}\n" .
                "\n" . str_repeat("─", 25) . "\n" .
                "Kami sampaikan mohon maaf keterlambatan pengiriman pesan ini. Semoga ananda {$nama} tetap selalu disiplin dan menaati aturan.\n Terima Kasih\n\n";
            $message = format_pesan('LAPORAN ABSENSI HARI INI', $isi);
            // $ResponWa = kirimPesanAbsensi($siswa->id, $data);
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $message);
            // langsung update field whatsapp_response
            Eabsen::where('id', $kirimWa->id)->update([
                'whatsapp_response' => $result['status'] ?? null,
            ]);
        }
        $this->info("Command 'CekPengirimanWaAbsensiCommand' berhasil dijalankan.");
    }
}
