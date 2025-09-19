<?php

namespace App\Console\Commands\Ekstra;

use App\Models\Admin\Etapel;
use App\Models\Admin\Identitas;
use App\Models\User\Guru\Detailguru;
use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Console\Command;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\WakaKesiswaan\Ekstra\PesertaEkstra;
use App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;

class PengingatEkstracommand extends Command
{
    protected $signature = 'ekstra:pengingat-ekstra';
    protected $description = 'Pengingat ekstra ke siswa dan orang tua';

    /*
        |--------------------------------------------------------------------------
        | 📌 Ekstra
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | -
        |
        | Tujuan :
        | - Jelaskan tujuan command ini
        | -
        |
        |
        | Penggunaan :
        | - Jelaskan penggunaannya dimana atau hubungannya
        | -
        |
        |
        |
    */

    public function handle()
    {

        // Tuliskan logika command di sini
        $Identitas = Identitas::first();
        $hari = Carbon::now()->locale('id')->dayName;
        $customHari = [
            'Senin'   => 'Senin',
            'Selasa'  => 'Selasa',
            'Rabu'    => 'Rabu',
            'Kamis'   => 'Kamis',
            'Jumat'   => "Jum'at",
            'Sabtu'   => 'Sabtu',
            'Minggu'  => 'Minggu',
        ];
        $etapels = Etapel::where('aktiv', 'Y')->first();
        $hariFinal = $customHari[$hari] ?? $hari;
        $Ekstra = RiwayatEkstra::where('tapel_id', $etapels->id)->where('jadwal', $hariFinal)->pluck('id');
        $Ekstra = RiwayatEkstra::where('tapel_id', $etapels->id)->get();
        $peserta = PesertaEkstra::where('tapel_id', $etapels->id)->whereIn('ekstra_id', $Ekstra->pluck('id'))->pluck('detailsiswa_id');
        if (!config('whatsappSession.WhatsappDev')) {
            $peserta  = PesertaEkstra::with('Siswa', 'EkstraNew')
                ->where('tapel_id', $etapels->id)
                ->whereIn('ekstra_id', $Ekstra->pluck('id'))
                ->get();
        } else {
            $peserta = PesertaEkstra::with('Siswa', 'EkstraNew')
                ->where('tapel_id', $etapels->id)
                ->whereIn('ekstra_id', $Ekstra->pluck('id'))->limit(5)->get();
        }
        foreach ($peserta as $PesertaInEkstra) {
            if (!config('whatsappSession.WhatsappDev')) {
                $sessions = getWaSessionByTingkat($peserta->Siswa->tingkat_id);
                $NoTujuan = $PesertaInEkstra->Siswa->ayah_nohp
                    ?? $PesertaInEkstra->Siswa->ibu_nohp
                    ?? config('whatsappSession.SekolahNoTujuan');
            } else {
                $sessions = config('whatsappSession.IdWaUtama');
                $NoTujuan = config('whatsappSession.DevNomorTujuan');
            }

            $hari = Carbon::create(now())->translatedformat('l, d F Y');
            $Guru = Detailguru::where('id', $PesertaInEkstra->Ekstra->detailguru_id)->first();
            $pelatih = $PesertaInEkstra->EkstraNew->pelatih ?? '-';
            $data = [
                'pembina' => $pembina = $Guru->nama_guru . ',' . $Guru->gelar ?? '-',
                'pelatih' => $PesertaInEkstra->EkstraNew->pelatih ?? '-',
                'hari' => $hari,
                'nama_sekolah' => $Identitas->namasek,
            ];
            $PesanKirim = pengingat_ekstra($PesertaInEkstra, $data);
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoTujuan, $PesanKirim);
        }
    }
}
