<?php

use imagick;
use Spatie\PdfToImage\Pdf;
use setasign\Fpdi\Fpdi;

/*
    |--------------------------------------------------------------------------
    | 📌 Imagick Instalasi :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - Download Imagick 7.1.2.Q16-HDRI di : https://imagemagick.org/script/download.php#windows
    | ✅ Install legacy utilities (convert, identify, etc)
    | ✅ Add to system PATH
    | - Download dan Extrak : php_imagick-3.7.0-8.1-ts-vs16-x64.zip di https://windows.php.net/downloads/pecl/releases/imagick/3.7.0/
    | - Root Ekstrak E:\laragon\bin\php\php-8.3.10-Win32-vs16-x64\ext
    |
    | Tujuan :
    | - Membuat Conversi pdf to image
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
    */
// Proses Coding

if (!function_exists('pdfToImageWa')) {
    function pdfToImageWa($namafile)
    {
        // Pastikan path ImageMagick sesuai
        $magickPath = escapeshellarg("C:\\Program Files\\ImageMagick-7.1.2-Q16-HDRI\\magick.exe");

        // Path file PDF (ambil halaman pertama aja [0])
        $pdfPath = escapeshellarg(base_path("Whatsapp/Uploads/{$namafile}.pdf") . '[0]');

        // Output path untuk JPEG
        $outputPath = escapeshellarg(base_path("Whatsapp/Uploads/{$namafile}.jpg"));

        // Command ImageMagick
        $command = "$magickPath -density 150 $pdfPath -quality 100 $outputPath";

        // Eksekusi command dan ambil outputnya kalau error
        exec($command . ' 2>&1', $output, $returnVar);

        if ($returnVar !== 0) {
            logger()->error("Gagal convert PDF ke gambar", ['output' => $output]);
            return false;
        }

        return $namafile; // Sukses, balikin nama file
    }
}
/*
// pdfFile = 'file1'
// uploadDir = 'whatsapp/uploads'
// outputName = 'file1_converted'
$result = pdfToImageWa('file1', 'whatsapp/uploads', 'file1_converted');
echo "File JPG hasil convert: $result";

*/
function pdfToImage($pdfFile, $uploadDir, $outputName = null)
{
    // Tentukan folder upload relatif ke base_path
    $uploadPath = base_path($uploadDir);

    // File PDF
    $pdfPath = $uploadPath . '/' . $pdfFile . '.pdf';
    if (!file_exists($pdfPath)) {
        throw new \Exception("File PDF tidak ditemukan: $pdfPath");
    }

    // Nama output default sama dengan nama file PDF kalau tidak diberikan
    $outputName = $outputName ?? pathinfo($pdfFile, PATHINFO_FILENAME);
    $outputPath = $uploadPath . '/' . $outputName . '.jpg';

    // Path magick.exe
    $magickPath = '"C:\Program Files\ImageMagick-7.1.2-Q16-HDRI\magick.exe"';

    // Command konversi halaman pertama PDF ke JPG
    $command = sprintf(
        '%s -density 300 %s[0] -background white -alpha remove -alpha off -quality 100 %s',
        $magickPath,
        escapeshellarg($pdfPath),
        escapeshellarg($outputPath)
    );

    exec($command, $output, $returnVar);

    if ($returnVar !== 0) {
        throw new \Exception("Konversi PDF ke JPG gagal. Command: $command");
    }

    return $outputPath;
}