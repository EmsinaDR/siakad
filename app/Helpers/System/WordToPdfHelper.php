<?php

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
