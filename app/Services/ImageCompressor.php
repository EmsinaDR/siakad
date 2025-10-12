<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Models\Image;

class ImageCompressor
{
    /**
     * Mengompresi gambar, menyimpannya, dan mengembalikan hasilnya.
     * Fungsi ini dapat digunakan untuk:
     * 1. Menyimpan gambar ke dalam database dan folder.
     * 2. Menyimpan gambar hanya ke folder tanpa database.
     * 3. Menyimpan gambar ke folder yang ditentukan oleh pengguna.
     *
     * @param  UploadedFile $imageFile  File gambar yang diunggah
     * @param  string       $folder     Folder tujuan untuk menyimpan gambar (default: 'temp')
     * @param  int          $resizeWidth  Lebar gambar setelah diubah ukuran (default: 800px)
     * @param  int          $resizeHeight Tinggi gambar setelah diubah ukuran (default: 600px)
     * @param  int          $maxFileSizeKB Batas ukuran file (dalam KB) (default: 200KB)
     * @param  bool         $saveToDatabase Menentukan apakah gambar akan disimpan ke database (default: true)
     * @return array|null   Data gambar yang telah dikompresi atau null jika gagal
     */
    public static function compress(
        UploadedFile $imageFile,
        $folder = 'temp',
        $resizeWidth = 800,
        $resizeHeight = 600,
        $maxFileSizeKB = 200,
        $saveToDatabase = true
    ) {
        // Tentukan nama file yang terkompresi
        $imageName = time() . '_' . $imageFile->getClientOriginalName();

        // Tentukan path folder yang akan digunakan untuk menyimpan gambar
        $storagePath = public_path($folder);

        // Pastikan folder tujuan ada, jika belum buat foldernya
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        // Tentukan path lengkap untuk gambar
        $imagePath = $folder . '/' . $imageName;
        $fullTempPath = $storagePath . '/temp_image.jpg';

        // Pastikan file yang diterima valid
        if (!$imageFile->isValid()) {
            return null;
        }

        // Membaca gambar dari file
        $img = imagecreatefromstring(file_get_contents($imageFile));
        if (!$img) {
            return null;
        }

        // Resize gambar sesuai ukuran yang ditentukan
        $resizedImg = imagescale($img, $resizeWidth, $resizeHeight);

        // Tentukan kualitas kompresi (90%)
        $compressionQuality = 90;

        // Simpan gambar dengan kualitas yang ditentukan
        imagejpeg($resizedImg, $fullTempPath, $compressionQuality);

        // Mengurangi kualitas kompresi sampai ukuran file sesuai batas
        while (filesize($fullTempPath) > $maxFileSizeKB * 1024 && $compressionQuality > 10) {
            $compressionQuality -= 5;
            imagejpeg($resizedImg, $fullTempPath, $compressionQuality);
        }

        // Pindahkan file sementara ke folder tujuan
        $finalPath = public_path($imagePath);
        if (rename($fullTempPath, $finalPath)) {
            // Hapus gambar dari memory
            imagedestroy($img);
            imagedestroy($resizedImg);

            // Jika menyimpan ke database
            if ($saveToDatabase) {
                $dbImage = Image::create([
                    'original_name' => $imageFile->getClientOriginalName(),
                    'compressed_name' => $imageName,
                    'path' => $imagePath,
                ]);

                return [
                    'id' => $dbImage->id,
                    'original_name' => $dbImage->original_name,
                    'path' => $dbImage->path,
                ];
            }

            // Jika tidak menyimpan ke database, kembalikan hanya path dan URL
            return [
                'filename' => $imageName,
                'path' => $imagePath,
                'url' => asset($imagePath),
                'size_kb' => round(filesize($finalPath) / 1024, 2),
            ];
        }

        return null;
    }
}

/*
Penjelasan:
Fungsi compress ini menangani semua tujuan yang berbeda yang sebelumnya ada dalam beberapa fungsi terpisah:
Menyimpan gambar yang terkompresi ke dalam database dan folder lokal (default, saveToDatabase = true).
Menyimpan gambar hanya ke folder lokal tanpa database (jika saveToDatabase = false).
Menyimpan gambar ke folder yang ditentukan (parameter $folder).

Parameter:

$imageFile: File gambar yang diunggah.
$folder: Folder tempat menyimpan gambar setelah diproses (default adalah temp).
$resizeWidth dan $resizeHeight: Ukuran gambar yang diubah (default 800x600).
$maxFileSizeKB: Batas ukuran file setelah kompresi (default 200 KB).
$saveToDatabase: Tentukan apakah gambar akan disimpan ke database. Jika true, informasi gambar akan disimpan di tabel images (default true).

Keluaran:
Jika $saveToDatabase adalah true, fungsi mengembalikan data yang mencakup id, original_name, dan path yang disimpan di database.
Jika $saveToDatabase adalah false, fungsi mengembalikan data gambar yang mencakup filename, path, url, dan size_kb (ukuran file dalam KB).




Catatan Penggunaan:
Menyimpan Gambar dan Database:

Untuk menyimpan gambar ke dalam folder dan database, panggil fungsi dengan parameter default:


$result = ImageCompressor::compress($imageFile);
Menyimpan Gambar Tanpa Database:

Untuk menyimpan gambar hanya di folder tanpa menyimpan ke database, panggil dengan parameter saveToDatabase = false:


$result = ImageCompressor::compress($imageFile, 'temp', 800, 600, 200, false);
Menentukan Folder Penyimpanan:

Anda bisa menentukan folder lain selain temp dengan mengganti parameter $folder:
$result = ImageCompressor::compress($imageFile, 'uploads/images', 800, 600, 200);

*/