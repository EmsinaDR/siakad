<?php
if (!function_exists('jpgToPng')) {
    /**
     * Konversi file JPG menjadi PNG (seragamkan semua file jadi .png)
     *
     * @param string $src Path file JPG sumber
     * @param string|null $dest Path tujuan (optional)
     * @return string|false Path hasil PNG kalau sukses, false kalau gagal
     */
    function jpgToPng($src, $dest = null)
    {
        if (!file_exists($src)) {
            echo "❌ File tidak ditemukan: $src\n";
            return false;
        }

        // Jika dest kosong → ganti ekstensi jadi .png di lokasi yang sama
        if (!$dest) {
            $dest = preg_replace('/\.(jpg|jpeg)$/i', '.png', $src);
        }

        // Buka gambar JPG
        $img = @imagecreatefromjpeg($src);
        if (!$img) {
            echo "❌ Gagal buka gambar JPG: $src\n";
            return false;
        }

        // Simpan jadi PNG kualitas tinggi
        if (!imagepng($img, $dest, 9)) {
            echo "❌ Gagal simpan PNG: $dest\n";
            imagedestroy($img);
            return false;
        }

        imagedestroy($img);
        echo "✅ Konversi sukses: " . basename($dest) . "\n";
        return $dest;
    }
}

/**
 * Loop folder sumber dan konversi semua JPG ke PNG di folder output
 *
 * @param string $srcFolder Folder sumber JPG
 * @param string $outputFolder Folder tujuan PNG
 * @return void
 */
function convertFolderJpgToPngAndBackupJpg($srcFolder, $outputFolder)
{
    $srcFolder = rtrim($srcFolder, '\\/') . '\\';
    $outputFolder = rtrim($outputFolder, '\\/') . '\\';

    if (!file_exists($outputFolder)) {
        mkdir($outputFolder, 0777, true);
    }

    // Ambil semua JPG / JPEG
    $files = glob($srcFolder . '*.jpg');
    $files = array_merge($files, glob($srcFolder . '*.jpeg'));

    $jpgFilesToBackup = []; // array untuk backup RAR

    foreach ($files as $file) {
        // Konversi ke PNG
        $dest = $outputFolder . basename(preg_replace('/\.(jpg|jpeg)$/i', '.png', $file));
        jpgToPng($file, $dest);

        // Simpan path JPG asli untuk backup
        $jpgFilesToBackup[] = $file;
    }

    // --- Backup JPG asli ke RAR ---
    if (!empty($jpgFilesToBackup)) {
        $rarFile = $srcFolder . 'backup_jpg_' . date('Ymd_His') . '.rar';
        $filesStr = implode(' ', array_map(fn($f) => '"' . $f . '"', $jpgFilesToBackup));

        // Ganti path WinRAR sesuai instalasi di komputer
        $winrarPath = '"C:\\Program Files\\WinRAR\\rar.exe"';

        $cmd = "$winrarPath a -r -ep1 \"$rarFile\" $filesStr";
        exec($cmd, $output, $return_var);

        if ($return_var === 0) {
            echo "✅ Backup JPG berhasil dibuat: $rarFile\n";

            // Hapus semua JPG asli
            foreach ($jpgFilesToBackup as $jpg) {
                @unlink($jpg);
                echo "🗑️ Dihapus: $jpg\n";
            }
        } else {
            echo "❌ Backup gagal, cek path WinRAR dan hak akses\n";
        }
    }
}
