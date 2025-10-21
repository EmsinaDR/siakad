<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 CommandControlHelper :
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - xxxxxxxxxxx
        | - xxxxxxxxxxx
        |
        | Tujuan :
        | - xxxxxxxxxxx
        |
        | Penggunaan :
        | - xxxxxxxxxxx
        |
    */

// Proses Coding

use Illuminate\Support\Facades\Artisan;

/*
penggunaan :
$output = run_artisan('system:rekap-data');

*/

if (!function_exists('run_artisan')) {
    /**
     * Jalankan perintah artisan secara modular
     *
     * @param  string  $command  Nama command artisan, misal: 'system:rekap-data'
     * @param  array   $params   Parameter opsional, misal: ['--bulan' => 10]
     * @param  bool    $return_output  Jika true, hasil output dikembalikan
     * @return string|bool
     */

    function run_artisan(string $command, array $params = [], bool $return_output = true)
    {
        try {
            Artisan::call($command, $params);

            if ($return_output) {
                return trim(Artisan::output());
            }

            return true;
        } catch (\Exception $e) {
            return '❌ Error: ' . $e->getMessage();
        }
    }
}
