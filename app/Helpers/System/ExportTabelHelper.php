<?php

use Carbon\Carbon;
use App\Models\Excel;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\DB;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
/*
        |--------------------------------------------------------------------------
        | 📌 System/ExportTabel :
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
if (! function_exists('export_table_to_excel')) {
    /**
     * Export table ke Excel
     *
     * @param string $table   Nama tabel
     * @param string $filename Nama file xlsx
     * @param string $mode     download|storage|path
     * @param string|null $target Lokasi target (kalau mode=path)
     * @return mixed
     */
    /*
    Cara Penggunaan :
    // 1. Download langsung ke browser
        return export_table_to_excel('siswa', 'siswa.xlsx', 'download');

        // 2. Simpan ke storage/app/exports/siswa.xlsx
        export_table_to_excel('siswa', 'siswa.xlsx', 'storage');

        // 3. Simpan langsung ke base_path()
        export_table_to_excel('siswa', 'siswa.xlsx', 'path', base_path('siswa.xlsx'));

        // 4. Simpan ke public folder
        export_table_to_excel('siswa', 'siswa.xlsx', 'path', public_path('siswa.xlsx'));

        */
    function export_table_to_excel($table, $filename = null, $mode = 'download', $target = null)
    {
        $data = DB::table($table)->get();
        $columns = DB::getSchemaBuilder()->getColumnListing($table);

        $exportData = collect([$columns])->merge(
            $data->map(fn($row) => (array) $row)
        );

        if (!$filename) {
            $filename = $table . '.xlsx';
        }

        $exporter = new class($exportData) implements FromCollection {
            private $data;
            public function __construct($data)
            {
                $this->data = $data;
            }
            public function collection()
            {
                return $this->data;
            }
        };

        switch ($mode) {
            case 'download':
                // Langsung ke browser
                return Excel::download($exporter, $filename);

            case 'storage':
                // Disimpan di storage/app/exports
                return Excel::store($exporter, 'exports/' . $filename, 'local');

            case 'path':
                // Disimpan di path bebas
                $content = Excel::raw($exporter, \Maatwebsite\Excel\Excel::XLSX);
                if (!$target) {
                    $target = base_path($filename); // default ke base_path
                }
                file_put_contents($target, $content);
                return $target; // return full path

            default:
                throw new InvalidArgumentException("Mode [$mode] tidak dikenal.");
        }
    }
}
