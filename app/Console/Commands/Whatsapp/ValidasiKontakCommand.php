<?php

namespace App\Console\Commands\Whatsapp;

use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ValidasiKontakCommand extends Command
{
    protected $signature = 'whatsapp:validasi-kontak';
    protected $description = 'Pengecekan no HP Valid atau tidak';

    public function handle()
    {
        $nomor = '6285329860005'; // bisa juga minta input user dengan $this->ask()

        // try {
        //     // endpoint sesuai dengan yang sudah kita buat
        //     $response = Http::get('http://127.0.0.1:3000/isregister', [
        //         'id' => 'Siswa',   // sesuaikan session ID
        //         'number' => $nomor
        //     ]);

        //     if ($response->successful()) {
        //         $hasil = $response->json();

        //         if (!empty($hasil['isRegistered']) && $hasil['isRegistered'] === true) {
        //             $this->info("{$hasil['isRegistered']}");
        //             $this->info("✅ Nomor {$hasil['number']} terdaftar di WhatsApp");
        //         } else {
        //             $this->error("❌ Nomor {$hasil['number']} tidak terdaftar di WhatsApp");
        //         }
        //     } else {
        //         $this->error("❌ Gagal cek nomor. Status: " . $response->status());
        //         $this->line($response->body());
        //     }
        // } catch (\Exception $e) {
        //     $this->error("❌ Terjadi error: " . $e->getMessage());
        // }


        $Siswa = Detailsiswa::get();
        $sessions = config('whatsappSession.IdWaUtama');
        foreach ($Siswa as $single):
            if ($single->ayah_nohp === null) {
                continue;
            } else {
                $Data = isWhatsappRegistered($single->ayah_nohp, $sessions);
                $Validation = true;
                if (!$Data) {
                    $Validation = 'Tidak Valid';
                    $this->info("{$single->nama_siswa}/ {$Validation}");
                    $single = Detailsiswa::where('id', $single->id)->update([
                        'ayah_nohp' => null,
                    ]);
                    $this->info("Telah dirubah");
                }
            }
            $this->info("Telah dirubah");

        endforeach;
    }
}
