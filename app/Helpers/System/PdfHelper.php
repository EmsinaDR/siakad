<?php

use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\File;

/**
 * Merge semua file PDF di folder jadi satu file output
 * setasign/fpdf setasign/fpdi fungsi merge
 */

/*
    |----------------------------------------------------------------------
    | 📌 Helper WordToPdfHelper
    |----------------------------------------------------------------------
    |
    Download: https://www.libreoffice.org/download/download/

    Setelah install, pastikan libreoffice masuk ke PATH.
    Biasanya lokasinya:
    C:\Program Files\LibreOffice\program\soffice.exe
    (bisa rename link ke libreoffice.bat biar gampang dipanggil)

    cara penggunaan :
    $folder = storage_path('app/docs');
    $output = storage_path('app/merged/hasil_gabungan.pdf');
    convert_word_to_pdf($folder);
    merge_pdf_in_folder($folder, $output);
    return response()->download($output);
*/

if (!function_exists('merge_pdf_in_folder')) {
    function merge_pdf_in_folder(string $folderPath, string $outputFile)
    {
        $pdf = new Fpdi();
        $files = File::files($folderPath);

        foreach ($files as $file) {
            if (strtolower($file->getExtension()) === 'pdf') {
                $pageCount = $pdf->setSourceFile($file->getRealPath());
                for ($i = 1; $i <= $pageCount; $i++) {
                    $tplIdx = $pdf->importPage($i);
                    $pdf->AddPage();
                    $pdf->useTemplate($tplIdx);
                }
            }
        }

        $pdf->Output($outputFile, 'F');
    }
}

/**
 * Deteksi path LibreOffice (Windows/Linux)
 */
if (!function_exists('get_libreoffice_path')) {
    function get_libreoffice_path(): string
    {
        if (stripos(PHP_OS, 'WIN') === 0) {
            $paths = [
                'C:\Program Files\LibreOffice\program\soffice.exe',
                'C:\Program Files (x86)\LibreOffice\program\soffice.exe',
            ];

            foreach ($paths as $path) {
                if (file_exists($path)) return $path;
            }

            throw new \Exception('LibreOffice tidak ditemukan di lokasi default Windows.');
        }

        return 'libreoffice';
    }
}

/*
Cara Penggunaan :
merge_pdf([
    public_path('doc1.pdf'),
    public_path('doc2.pdf'),
    public_path('doc3.pdf'),
], public_path('hasil.pdf'));
*/

if (!function_exists('merge_pdf')) {
    function merge_pdf(array $pdfFiles, string $outputFile)
    {
        $pdf = new Fpdi();

        foreach ($pdfFiles as $file) {
            if (!file_exists($file)) continue;

            $pageCount = $pdf->setSourceFile($file);

            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i);
                $pdf->AddPage();
                $pdf->useTemplate($tplIdx);
            }
        }

        $pdf->Output($outputFile, 'F');
    }
}

// Merge Pdf
if (!function_exists('merge_pdfs_in_folder')) {
    /**
     * Menggabungkan semua file PDF dalam satu folder menjadi satu file.
     *
     * @param string $inputPath  Path folder berisi PDF
     * @param string|null $outputPath  Path output hasil merge (optional)
     * @return string|null  Path file hasil merge atau null jika gagal
     */
    function merge_pdfs_in_folder(string $inputPath, ?string $outputPath = null): ?string
    {
        if (!File::exists($inputPath) || !File::isDirectory($inputPath)) {
            throw new \Exception("Folder tidak ditemukan: {$inputPath}");
        }

        $pdfFiles = File::files($inputPath);
        if (empty($pdfFiles)) {
            return null;
        }

        // Default output path
        if (!$outputPath) {
            $outputPath = rtrim($inputPath, '/\\') . '/merged.pdf';
        }

        $pdf = new Fpdi();

        foreach ($pdfFiles as $file) {
            if (strtolower($file->getExtension()) === 'pdf') {
                $pageCount = $pdf->setSourceFile($file->getPathname());

                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $tplIdx = $pdf->importPage($pageNo);
                    $size = $pdf->getTemplateSize($tplIdx);

                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($tplIdx, 0, 0, $size['width'], $size['height']);
                }
            }
        }

        $pdf->Output($outputPath, 'F');
        return $outputPath;
    }

    /*
    Cara Penggunaan :
        try {
            $merged = merge_pdfs_in_folder(public_path('temp/perangkat-test/pdf'));
            if ($merged) {
                echo "✅ File hasil merge: $merged";
            } else {
                echo "⚠️ Tidak ada file PDF ditemukan.";
            }
        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage();
        }

    */
}
