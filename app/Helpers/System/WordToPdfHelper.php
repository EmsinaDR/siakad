<?php

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

use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\File;

/**
 * Convert semua file Word (.doc / .docx) di folder ke PDF
 */
if (!function_exists('convert_word_to_pdf')) {
    function convert_word_to_pdf(string $folderPath)
    {
        $files = File::files($folderPath);
        $soffice = get_libreoffice_path();

        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['doc', 'docx'])) {
                $outputDir = escapeshellarg($folderPath);
                $inputFile = escapeshellarg($file->getRealPath());

                $cmd = "\"$soffice\" --headless --convert-to pdf $inputFile --outdir $outputDir";
                exec($cmd);
            }
        }
    }
}

/**
 * Merge semua file PDF di folder jadi satu file output
 * setasign/fpdf setasign/fpdi fungsi merge
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
