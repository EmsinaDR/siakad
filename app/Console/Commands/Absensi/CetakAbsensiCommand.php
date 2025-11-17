<?php

namespace App\Console\Commands\Absensi;

use Illuminate\Console\Command;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;

class CetakAbsensiCommand extends Command
{
    protected $signature = 'absensi:cetak-absensi-guru';
    protected $description = 'Mencetak absensi otomatis';

    public function handle()
    {

        if (!config('whatsappSession.WhatsappDev')) {
            $gurus = Detailguru::whereNotIn('id', [1, 2, 3])->get();
            $numberKepala = config('whatsappSession.NoKepala');
            $numberBos = config('whatsappSession.NoBendaharaBos');
            $number = [$numberKepala, $numberBos];
        } else {
            $gurus = Detailguru::whereNotIn('id', [1, 2, 3])->limit(5)->get();
            $number = config('whatsappSession.DevNomorTujuan');
        }

        // $sessions = config('whatsappSession.IdWaUtama');
        // $filename = 'absensi.zip';
        // $filePath = base_path('whatsapp/uploads/' . $filename);
        // $bulan = bulanIndo(date('m') - 1);
        // $caption =
        //     "Berikut ini laporan absensi semua guru {$bulan}";
        // $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $number, format_pesan_gb('Laporan Absensi', $caption), $filePath);




        $message = "EAG/Kepala/Kode Guru/Bulan";
        $pesan = "EAG/Kepala/Kode Guru/Bulan";
        # code...
        foreach ($gurus as $guru):
            $kode_guru = $guru->kode_guru;
            $bulan = date('m') - 1;

            $DataAbsen = exportlaporan($kode_guru, $bulan);

            // Pastikan hasilnya selalu Collection (nggak null atau array)
            $DataAbsen = collect($DataAbsen ?? []);

            // Kalau nggak ada data absensi, lanjut ke guru berikutnya
            if ($DataAbsen->isEmpty()) {
                $this->warn("⏭️ Tidak ada data absensi untuk guru {$kode_guru}");
                continue;
            }

            $dataTambahan = [
                'data' => '$DataAbsen'
            ];
            $dataIdentitas = DataIdentitas();
            $data = array_merge($dataTambahan, [
                'DataAbsen' => $DataAbsen
            ], $dataIdentitas);

            $folder = public_path('temp/export/absensi');
            $view = 'role.absensi.eabsenguru.export-excel-absensi-guru';
            $filename = 'Rekap Absensi Kode Guru ' . $kode_guru . ' - ' . bulanIndo($bulan);

            $hasil = DomExport($filename, $data, $view, $folder);
            $respon = CopyFileWa($filename . '.pdf', 'temp/export/absensi');

            $PesanKirim = "File Export Laporan Absensi {$kode_guru}\n\n";
            $filename = $filename . '.pdf';
            $filePath = base_path('whatsapp/uploads/' . $filename);
            $this->warn("⏭️ Proses guru {$kode_guru}");
        endforeach;

        $result = create_zip(public_path('temp/export/absensi'), public_path('temp/export/absensi/absensi.zip'));
        $sessions = config('whatsappSession.IdWaUtama');
        $filename = 'absensi.zip';
        // CopyFileWa()
        CopyFileWa($filename, 'temp/export/absensi');
        $filePath = base_path('whatsapp/uploads/' . $filename);
        $bulan = bulanIndo(date('m') - 1);
        $caption =
            "Berikut ini laporan absensi semua guru {$bulan}";
        $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $number, format_pesan_gb('Laporan Absensi', $caption), $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp
        // $kirimMedia = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $number, $message);
        $this->info("Command 'CetakAbsensiCommand' berhasil dijalankan.");
    }
}
