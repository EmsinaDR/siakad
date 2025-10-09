<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * === LARAVEL SCAN HELPER TANPA CLASS (VERSI JELAS + DEBUG) ===
 * - Tampil semua error
 * - Proses konversi, rename, upload, dan cleanup
 */

if (!function_exists('getScannedFiles')) {
    function getScannedFiles($folder)
    {
        $files = glob($folder . DIRECTORY_SEPARATOR . 'img_*.jpg');
        natsort($files);
        return array_values($files);
    }
}

if (!function_exists('isBatchComplete')) {
    function isBatchComplete($files, $totalDocs)
    {
        return count($files) === $totalDocs;
    }
}

if (!function_exists('convertToPng')) {
    function convertToPng($src, $dest)
    {
        if (!file_exists($src)) {
            echo "❌ File tidak ditemukan: $src\n";
            return false;
        }

        $img = @imagecreatefromjpeg($src);
        if (!$img) {
            echo "❌ Gagal buka file gambar: $src\n";
            return false;
        }

        if (!imagepng($img, $dest, 9)) {
            echo "❌ Gagal menyimpan PNG ke: $dest\n";
            imagedestroy($img);
            return false;
        }

        imagedestroy($img);
        unlink($src);
        return true;
    }
}

if (!function_exists('uploadToLaravel')) {
    function uploadToLaravel($api, $no_pendaftaran, $nama, $filePath)
    {
        echo "📤 Uploading {$nama}...\n";

        if (!file_exists($filePath)) {
            echo "❌ File hilang sebelum upload: $filePath\n";
            return false;
        }

        $ch = curl_init($api);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            'no_pendaftaran' => $no_pendaftaran,
            'nama'           => $nama,
            'file'           => new CURLFile($filePath)
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo "❌ CURL Error: " . curl_error($ch) . "\n";
        } else {
            echo "✅ Upload sukses: {$nama}\n";
        }

        curl_close($ch);
        return $result;
    }
}

if (!function_exists('cleanupFolder')) {
    function cleanupFolder($folder)
    {
        $files = glob($folder . DIRECTORY_SEPARATOR . '*.png');
        foreach ($files as $file) {
            unlink($file);
        }
        echo "🧹 Folder dibersihkan.\n";
    }
}

/*
runScanWatcher("C:\\scan_buffer", route('api.upload-scan'), "2025001", ["kk", "ijazah", "akta", "ktp", "formulir"]);

*/
if (!function_exists('runScanWatcher')) {
    function runScanWatcher($folder, $laravelApi, $no_pendaftaran, $templates)
    {
        $totalDocs = count($templates);
        echo "👀 Watcher aktif. Pantau folder: $folder\n";

        while (true) {
            $files = getScannedFiles($folder);

            if (isBatchComplete($files, $totalDocs)) {
                echo "\n✅ Batch lengkap (" . count($files) . " file)\n";

                foreach ($files as $i => $file) {
                    $name = $templates[$i] ?? "doc_" . ($i + 1);
                    $new  = $folder . DIRECTORY_SEPARATOR . "{$no_pendaftaran}_{$name}.png";

                    echo "⚙️  Proses: " . basename($file) . " → " . basename($new) . "\n";

                    if (convertToPng($file, $new)) {
                        uploadToLaravel($laravelApi, $no_pendaftaran, $name, $new);
                    } else {
                        echo "⚠️ Gagal konversi " . basename($file) . "\n";
                    }
                }

                cleanupFolder($folder);
                echo "Menunggu batch berikutnya...\n";
                sleep(5);
            } else {
                if (count($files) > 0) {
                    echo "⏳ Belum lengkap (" . count($files) . " / $totalDocs)\r";
                }
                sleep(3);
            }
        }
    }
}
