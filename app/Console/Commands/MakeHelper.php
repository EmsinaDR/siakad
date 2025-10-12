<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeHelper extends Command
{
    /*
    |--------------------------------------------------------------------------
    | 📌 Command Pembuatan Helper :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - Pembuatan file helper otomatis
    | - Menambahkan require_once ke Helpers.php
    |
    | Tujuan :
    | - Memudahkan generate helper baru dengan cepat
    |
    | Penggunaan :
    | - php artisan make:helper TglWaktu
    |
    */

    protected $signature = 'make:helper {name} {--force : Timpa file jika sudah ada}';

    public function handle()
    {
        $name = $this->argument('name');
        $force = $this->option('force');

        $helperDir = app_path('Helpers');
        $helperFile = $helperDir . '/' . $name . '.php';

        if (!File::exists($helperDir)) {
            File::makeDirectory($helperDir);
        }

        if (File::exists($helperFile) && !$force) {
            $this->error("❌ Helper $name.php sudah ada! Gunakan --force untuk menimpa.");
            return;
        }

        if ($force) {
            $this->warn("⚠️ Menimpa file $name.php karena --force dipakai.");
        }

        $stub = <<<PHP
<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

    /*
        |--------------------------------------------------------------------------
        | 📌 $name :
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
if (!function_exists('$name')) {
    function $name()
    {
        // TODO: Implement your helper logic here
    }
}
PHP;

        File::put($helperFile, $stub);
        $this->info("✅ Helper created at: app/Helpers/$name.php");

        // Inject ke Helpers.php
        $helpersIndexFile = $helperDir . '/Helpers.php';
        $requireLine = "require_once __DIR__ . '/$name.php';";

        if (File::exists($helpersIndexFile)) {
            $currentContents = File::get($helpersIndexFile);
            if (!str_contains($currentContents, $requireLine)) {
                File::append($helpersIndexFile, "\n$requireLine");
                $this->info("📌 Baris require '$name.php' ditambahkan ke Helpers.php");
            } else {
                $this->warn("⚠️ Baris require '$name.php' sudah ada di Helpers.php");
            }
        } else {
            $this->warn("⚠️ Helpers.php tidak ditemukan di $helperDir");
        }
    }
}
