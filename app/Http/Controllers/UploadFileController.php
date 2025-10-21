<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\UploadFile;
use Illuminate\Http\Request;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UploadFileController extends Controller
{
    //
    public function UploadLogo(Request $request)
    {
        // 1. Validasi inputan, harus berupa file gambar maksimal 20MB
        $validator = Validator::make($request->all(), [
            'logo' => 'required|image|max:20000',
        ]);

        if ($validator->fails()) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Ambil file logo setelah lolos validasi
        $file = $request->file('logo');

        // 3. Compress file menggunakan ImageCompressor
        $result = \App\Services\ImageCompressor::compress($file, '/temp', 800, 600, 200, false);

        if ($result === null) {
            // Jika gagal compress, redirect dengan pesan error
            return redirect()->back()
                ->with('error', 'Gagal kompres logo!')
                ->withInput();
        }

        // 4. Dapatkan path file hasil compress sementara
        $compressedPath = public_path($result['path']);

        // 5. Siapkan nama file baru
        $newFileName = 'logo.png'; // Dipaksa jadi ekstensi .jpg
        $logoIco = 'logo.ico';     // Nama file untuk versi .ico

        // 6. Pastikan folder 'img' ada, kalau belum ada buat folder baru
        $imgPath = public_path('img');
        if (!file_exists($imgPath)) {
            mkdir($imgPath, 0755, true);
        }

        // 7. Buka file hasil compress dan konversi isinya ke JPG
        $imageContent = file_get_contents($compressedPath);
        $imageResource = imagecreatefromstring($imageContent);

        if ($imageResource === false) {
            // Jika gagal baca gambar, redirect dengan error
            return redirect()->back()
                ->with('error', 'Gagal konversi gambar ke JPG!')
                ->withInput();
        }

        // Simpan hasil konversi ke img/logo.png
        imagejpeg($imageResource, $imgPath . '/' . $newFileName, 90);
        imagedestroy($imageResource); // Hapus dari memory server

        // 8. Copy hasil JPG untuk membuat file .ico
        copy($imgPath . '/' . $newFileName, $imgPath . '/' . $logoIco);

        // 9. Hapus file sementara di /temp agar folder tidak penuh sampah
        if (file_exists($compressedPath)) {
            unlink($compressedPath); // Hapus file temp
        }

        // 10. Selesai! Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Logo berhasil diupload, dikompres, dan dikonversi ke JPG!');
    }


    // public function UploadLogo(Request $request)
    // {
    //     // dd($request->all());
    //     $file = $request->file('logo');
    //     $result = ImageCompressor::compress($imageFile, 'uploads/images', 800, 600, 200);
    //     $validator = Validator::make($request->all(), [
    //         // 'logo' => 'required|image|dimensions:width=300,height=300|max:255',
    //         'logo' => 'required|image|max:255',
    //     ]);

    //     //Pengecekan adanya error dan redirect
    //     if ($validator->fails()) {
    //         // return redirect()->back()->with('Title', 'Upload Gagal !!!')->with('gagal', 'Logo Gagal Upload')
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }
    //     // dd($validator->fails()); //Mengecek Validasi output true or false
    //     // dd($validator->fails());

    //     // Dapatkan nama file asli
    //     $fileName = $file->getClientOriginalName();
    //     $fileName = explode('.', $fileName);
    //     $NewName = 'logo.' . end($fileName); // contoh logo.png
    //     $LogoIco = 'logo.ico'; // contoh logo.ico

    //     $path = public_path('img');

    //     // Pastikan folder 'img' ada
    //     if (!file_exists($path)) {
    //         mkdir($path, 0755, true);
    //     }

    //     // Simpan file asli
    //     $file->move($path, $NewName);

    //     // Copy file tersebut jadi .ico
    //     copy($path . '/' . $NewName, $path . '/' . $LogoIco);


    //     // dd($request->validate);
    //     // dd($NewName);

    //     //Nama File : request->file('name')->getClientOriginalName()
    //     //Size Upload : getSize()
    //     //Get Extension : $file->getClientOriginalExtension();
    //     //Get type (mimeType ) :$file->getMimeType();
    //     //Validasi : 'file' => 'required|mimes:jpg,png,pdf|max:2048'
    //     //Get File Sementara : $file->getPathname();
    //     // dd($request->file('logo')->getClientOriginalName());
    //     // move_uploaded_file($tempatfilesementara, $targetFilePath);
    //     return Redirect::back()->with('Title', 'Upload Logo')->with('Success', 'Upload Logo Sukses dan telah disimpan');
    //     // return Redirect::back()->with('Title', 'Berhasil !!!')->with('Success', 'Data  datahaps Berhasil dihapus dari databse');
    // }

    public function UploadFotoGuru($id, Request $request)
    {
        try {
            // 1. Ambil file yang diupload
            $file = $request->file('profile');

            // 2. Validasi file upload
            $validator = Validator::make($request->all(), [
                'profile' => 'required|mimes:jpeg,png,jpg,webp|image', // Maksimal 500KB
                // 'profile' => 'required|mimes:jpeg,png,jpg|image|max:500', // Maksimal 500KB
            ]);

            if ($validator->fails()) {
                // Jika validasi gagal, kembalikan dengan pesan error
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // 3. Compress file sebelum menyimpannya
                $result = \App\Services\ImageCompressor::compress($file, '/temp', 400, 400, 200, false);

            if ($result === null) {
                // Jika gagal kompresi, kembalikan dengan pesan error
                return redirect()->back()
                    ->with('error', 'Gagal kompres foto profile!')
                    ->withInput();
            }

            // 4. Ambil path file hasil kompres
            $compressedPath = public_path($result['path']);

            // 5. Buat nama file baru, paksa menjadi PNG
            $newFileName = $request->id . '.png';

            // 6. Pastikan folder img/guru ada
            $imgPath = public_path('img/guru');
            if (!file_exists($imgPath)) {
                mkdir($imgPath, 0755, true);
            }

            // 7. Simpan hasil kompresi ke dalam folder img/guru sebagai PNG
            $imageContent = file_get_contents($compressedPath);
            $imageResource = imagecreatefromstring($imageContent);

            if ($imageResource === false) {
                // Jika gagal konversi, kembalikan dengan error
                return redirect()->back()
                    ->with('error', 'Gagal konversi foto profile ke PNG!')
                    ->withInput();
            }

            // Simpan gambar sebagai PNG
            imagepng($imageResource, $imgPath . '/' . $newFileName, 9); // 9 = tingkat kompresi terbaik untuk PNG
            imagedestroy($imageResource); // Hapus dari memory

            // 8. Hapus file temp setelah digunakan
            if (file_exists($compressedPath)) {
                unlink($compressedPath);
            }

            // 9. Update data guru dengan nama foto yang baru
            $data = Detailguru::find($request->id);
            if ($data) {
                $data->foto = $newFileName;
                $data->save(); // Simpan perubahan data guru
            }

            // 10. Selesai, redirect dengan pesan sukses
            return redirect()->back()->with('Title', 'Upload Foto Profile')
                ->with('Success', 'Foto profile berhasil diupload, dikompres, dan dikonversi ke PNG!');
        } catch (Exception $e) {
            // Jika terjadi exception, kembalikan dengan pesan error
            return redirect()->back()
                ->with('Title', 'Gagal')
                ->with('gagal', 'Terjadi kesalahan saat upload foto profile.');
        }
    }
}

                // 'logo' => 'required|image|dimensions:width=300,height=300|max:255',
                //=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',