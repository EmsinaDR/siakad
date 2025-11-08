<?php

use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 CoCardHelper :
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
if (!function_exists('generate_personalized_svg')) {
    function generate_personalized_svg($data)
    {
        if (is_array($data)) {
            $data = (object) $data;
        }

        $templatePath = public_path('img/template/cocard/cocard003.svg');

        if (!file_exists($templatePath)) {
            Log::error("TEMPLATE GAK ADA di {$templatePath}");
            return null;
        }

        $svg = file_get_contents($templatePath);
        dd($svg);
        foreach ($data as $key => $value) {
            $svg = str_replace('{' . $key . '}', $value ?? '-', $svg);
        }

        $safeFilename = preg_replace('/[^A-Za-z0-9\-]/', '_', $data->kode);
        $outputPath = public_path("temp/cocard-{$safeFilename}.svg");

        try {
            $success = file_put_contents($outputPath, $svg);

            if ($success === false) {
                Log::error("GAGAL simpan SVG di {$outputPath}");
                return null;
            }

            Log::info("Berhasil simpan SVG di {$outputPath}");
            return asset("temp/cocard-{$safeFilename}.svg");
        } catch (\Exception $e) {
            Log::error("Exception saat simpan SVG: " . $e->getMessage());
            return null;
        }
    }
}
