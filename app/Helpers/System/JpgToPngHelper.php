<?php

use thiagoalessio\TesseractOCR\TesseractOCR;

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

if (!function_exists('extract_kk_all')) {
    function extract_kk_all($basePath, $filename)
    {
        $imagePath = rtrim($basePath, '/') . '/' . ltrim($filename, '/');

        // Jalankan OCR
        $ocr = new TesseractOCR($imagePath);
        $ocr->executable('C:\Program Files\Tesseract-OCR\tesseract.exe');
        $text = $ocr->lang('ind')->run();

        // Bersihkan teks dari noise
        $clean = strtoupper($text);
        $clean = str_replace(["\n", "\r", "\t"], ' ', $clean);
        $clean = preg_replace('/[^A-Z0-9\s\.\:\-\/]/', ' ', $clean);
        $clean = preg_replace('/\s+/', ' ', $clean);

        // Ambil bagian header KK
        $no_kk = extract_pattern($clean, '/NO[^\d]{0,5}(\d{16})/');
        $nama_kepala = extract_pattern($clean, '/NAMA\s+KEPALA\s+KELUARGA[^\w]*([A-Z\s]{3,40})/');
        $alamat = extract_pattern($clean, '/ALAMAT[^\w]*([A-Z0-9\s\/\-]+)/');
        $desa = extract_pattern($clean, '/DESA|KELURAHAN[^\w]*([A-Z\s]+)/');
        $kecamatan = extract_pattern($clean, '/KECAMATAN[^\w]*([A-Z\s]+)/');
        $kabupaten = extract_pattern($clean, '/KABUPATEN|KOTA[^\w]*([A-Z\s]+)/');
        $provinsi = extract_pattern($clean, '/PROVINSI[^\w]*([A-Z\s]+)/');

        // Ambil semua kemungkinan 16 digit (NIK & No KK)
        preg_match_all('/\b\d{16}\b/', $clean, $matches);
        $all_numbers = array_unique($matches[0]);

        // Ambil semua kemungkinan nama kapital panjang (heuristik)
        preg_match_all('/\b[A-Z\s]{3,40}\b/', $clean, $names);
        $possible_names = array_filter(array_map('trim', $names[0]), function ($n) {
            return strlen($n) > 5 && !str_contains($n, 'NAMA') && !str_contains($n, 'KEPALA');
        });

        // Gabungkan hasil
        return [
            'no_kk' => $no_kk,
            'nama_kepala_keluarga' => $nama_kepala,
            'alamat' => trim($alamat ?? ''),
            'desa_kelurahan' => trim($desa ?? ''),
            'kecamatan' => trim($kecamatan ?? ''),
            'kabupaten_kota' => trim($kabupaten ?? ''),
            'provinsi' => trim($provinsi ?? ''),
            'daftar_nik' => array_values($all_numbers),
            'daftar_nama' => array_values($possible_names),
            'raw_text' => $text,
        ];
    }
}

// if (!function_exists('extract_pattern')) {
//     function extract_pattern($text, $pattern)
//     {
//         if (preg_match($pattern, $text, $matches)) {
//             return trim($matches[1]);
//         }
//         return null;
//     }
// }
if (!function_exists('extract_kk')) {
    function extract_kk($basePath, $filename)
    {
        $imagePath = rtrim($basePath, '/') . '/' . ltrim($filename, '/');

        $ocr = new \thiagoalessio\TesseractOCR\TesseractOCR($imagePath);
        $ocr->executable('C:\Program Files\Tesseract-OCR\tesseract.exe');
        $text = $ocr->lang('ind')->run();

        // --- 1️⃣ Bersihkan teks mentah ---
        $clean = strtoupper($text);
        $clean = preg_replace('/[^A-Z0-9\s\.\,\:\-\/]/', ' ', $clean);
        $clean = preg_replace('/\s+/', ' ', $clean);

        // --- 2️⃣ Ambil header KK ---
        $no_kk = extract_pattern($clean, '/NO[\.\s]*KK[\s\:\-]*([0-9]{16})/');
        if (!$no_kk && preg_match('/\b\d{16}\b/', $clean, $m)) {
            $no_kk = $m[0];
        }

        $nama_kepala = extract_pattern($clean, '/NAMA\s+KEPALA\s+KELUARGA[\s\:\-]*([A-Z\s\.]+)/');
        $alamat = extract_pattern($clean, '/ALAMAT[\s\:\-]*([A-Z0-9\s]+)/');
        $provinsi = extract_pattern($clean, '/PROVINSI[\s\:\-]*([A-Z\s]+)/');
        $kabupaten = extract_pattern($clean, '/KABUPATEN|KOTA[\s\:\-]*([A-Z\s]+)/');
        $kecamatan = extract_pattern($clean, '/KECAMATAN[\s\:\-]*([A-Z\s]+)/');
        $desa = extract_pattern($clean, '/DESA|KELURAHAN[\s\:\-]*([A-Z\s]+)/');

        // --- 3️⃣ Ekstrak semua NIK ---
        preg_match_all('/\b\d{16}\b/', $clean, $nik_matches);
        $daftar_nik = array_unique($nik_matches[0]);

        // --- 4️⃣ Potong teks per-baris untuk cari anggota ---
        $lines = preg_split('/(?<=\d)\s+(?=\d{16})|[\n\r]+/', $text);
        $anggota = [];

        foreach ($lines as $line) {
            $line = strtoupper(trim($line));
            if (preg_match('/\b\d{16}\b/', $line, $nikMatch)) {
                $nik = $nikMatch[0];
                $sisa = trim(str_replace($nik, '', $line));

                // Ambil nama (teks kapital panjang sebelum TTL/jenis kelamin)
                preg_match('/([A-Z\s]{3,})/', $sisa, $nm);
                $nama = isset($nm[1]) ? ucwords(strtolower(trim($nm[1]))) : null;

                // Ambil TTL (format tanggal 01-01-2000 atau mirip)
                preg_match('/(\d{2}[\-\/\.]\d{2}[\-\/\.]\d{4})/', $sisa, $ttl);
                $ttl = $ttl[1] ?? null;

                // Cari jenis kelamin (L / P)
                preg_match('/\b(L|P)\b/', $sisa, $jk);
                $jk = $jk[1] ?? null;

                $anggota[] = [
                    'nik' => $nik,
                    'nama' => $nama,
                    'tanggal_lahir' => $ttl,
                    'jenis_kelamin' => $jk
                ];
            }
        }

        // --- 5️⃣ Hasil akhir ---
        return [
            'no_kk' => $no_kk,
            'nama_kepala_keluarga' => clean_name($nama_kepala),
            'alamat' => clean_name($alamat),
            'desa_kelurahan' => clean_name($desa),
            'kecamatan' => clean_name($kecamatan),
            'kabupaten_kota' => clean_name($kabupaten),
            'provinsi' => clean_name($provinsi),
            'anggota_keluarga' => $anggota,
            'raw_text' => $text,
        ];
    }
}

if (!function_exists('extract_pattern')) {
    function extract_pattern($text, $pattern)
    {
        if (preg_match($pattern, $text, $matches)) {
            return isset($matches[1]) ? trim($matches[1]) : null;
        }
        return null;
    }
}

if (!function_exists('clean_name')) {
    function clean_name($text)
    {
        if (!$text) return null;
        $text = preg_replace('/[^A-Z\s\.]/', '', strtoupper($text));
        $text = preg_replace('/\s+/', ' ', trim($text));
        return ucwords(strtolower($text));
    }
}
