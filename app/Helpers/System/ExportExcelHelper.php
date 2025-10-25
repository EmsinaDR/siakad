<?php

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Excel as ExcelFormat;

/*
    |----------------------------------------------------------------------
    | 📌 Helper ExportExcel
    |----------------------------------------------------------------------
    |
*/

if (! function_exists('export_excel')) {
    /**
     * Export Excel sederhana
     *
     * @param string $filename Nama file (contoh: students.xlsx)
     * @param array  $headings Header kolom
     * @param array  $data     Data array (baris-baris)
     * @param string $mode     download | store
     * @param string|null $path Lokasi simpan (default base_path('exports'))
     */
    // cara penggunaan
    /*
    :: Download langsung ke user
     $students = \App\Models\Student::select('id','name','nis','class','average_score')
        ->orderBy('kelas_id', 'ASC')
        ->get()
        ->map(fn($s) => [
            $s->id,
            $s->name,
            $s->nis,
            $s->class,
            $s->average_score,
        ])
        ->toArray();

    return export_excel(
        'students.xlsx',
        ['ID','Nama','NIS','Kelas','Nilai Rata-rata'],
        $students
    );
    :: Simpan ke folder
     $students = \App\Models\Student::select('id','name','nis','class','average_score')
        ->orderBy('kelas_id', 'ASC')
        ->get()
        ->map(fn($s) => [
            $s->id,
            $s->name,
            $s->nis,
            $s->class,
            $s->average_score,
        ])
        ->toArray();

    $filePath = export_excel(
        'students.xlsx',
        ['ID','Nama','NIS','Kelas','Nilai Rata-rata'],
        $students,
        'store',
        base_path('whatsapp/export')
    );

    dd("File tersimpan di: " . $filePath);

    */
    function export_excel($filename, array $headings, array $data, string $mode = 'download', string $path = null)
    {
        $export = new class($headings, $data) implements FromArray {
            protected $headings;
            protected $data;

            public function __construct($headings, $data)
            {
                $this->headings = $headings;
                $this->data = $data;
            }

            public function array(): array
            {
                return array_merge([$this->headings], $this->data);
            }
        };

        if ($mode === 'store') {
            $path = $path ?? base_path('exports');

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $fullPath = $path . DIRECTORY_SEPARATOR . $filename;

            // generate binary excel
            $content = Excel::raw($export, ExcelFormat::XLSX);

            // tulis ke file
            file_put_contents($fullPath, $content);

            return $fullPath;
        }
        Excel::download($export, $filename);
        // default: download
        return;
    }
}
// versi sederhanay export excel
/*
$students = Detailsiswa::with('KelasOne')
    ->select($selectData)
    ->orderBy('kelas_id', 'ASC')
    ->orderBy('id', 'ASC')
    ->get()
    ->values() // reset index
    ->map(function($s, $i) {
        return [
            $i + 1, // nomor urut manual
            $s->nama_siswa,
            $s->KelasOne?->kelas ?? '-',
            $s->nis,
            $s->nisn,
        ];
    })->toArray();

$headers = ['No', 'Nama Siswa', 'Kelas', 'NIS', 'NISN'];
*/