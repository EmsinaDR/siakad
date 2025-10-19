<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Models\Image;  // Model Image
use Illuminate\Support\Facades\File; // Import File facade

use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini bro
use Intervention\Image\Facades\Image as ImageIntervention;  // Aliasing Image untuk Intervention Image

class ImageController extends Controller
{
    // Menampilkan halaman kompresi gambar
    public function index()
    {
        $title = 'Image Compres';
        $arr_ths = [
            'Nama Siswa',
            'Kelas',
            'Pembimbing',
            'Hari Bimbingan',
        ];
        $breadcrumb = 'Tools / Image Compres';
        $images = Image::latest()->get(); // Kalau udah upload
        // atau:
        $images = collect(); // Kalau lo disable ambil dari DB
        return view('tools.Kompres.index', compact(
            'images',
            'title',
            'arr_ths',
            'breadcrumb'
        ));
    }
    public function indexImage()
    {
        $title = 'Image Compres';
        $arr_ths = [
            'Nama Siswa',
            'Kelas',
            'Pembimbing',
            'Hari Bimbingan',
        ];
        $breadcrumb = 'Tools / Image Compres';
        $images = Image::latest()->get();
        return view('tools.Kompres.ImageCompres', compact(
            'images',
            'title',
            'arr_ths',
            'breadcrumb'
        ));
    }

    // Menangani proses kompresi gambar
    public function compress(Request $request)
    {
        $title = 'Image Compress';
        $arr_ths = [
            'Nama Siswa',
            'Kelas',
            'Pembimbing',
            'Hari Bimbingan',
        ];
        $breadcrumb = 'Tools / Image Compress';

        // Validasi input
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $images = [];
        $path = public_path('temp'); // Menyimpan gambar di folder temp

        if (!file_exists($path)) {
            mkdir($path, 0777, true); // Membuat folder temp jika belum ada
        }

        // Menyimpan setiap gambar yang di-upload dan mengompresnya
        foreach ($request->file('images') as $image) {
            // Menyusun nama file dan path
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'temp/' . $imageName;

            // Pastikan file yang diterima benar-benar gambar
            if (!$image->isValid()) {
                continue;
            }

            // Menggunakan GD untuk membuka gambar
            $img = @imagecreatefromstring(file_get_contents($image->getRealPath()));

            if (!$img) {
                continue; // Skip jika file tidak bisa dibaca sebagai gambar
            }

            // Tentukan ukuran baru untuk gambar
            $width = 800;  // Misalnya 800px lebar
            $height = 600; // Misalnya 600px tinggi

            // Membuat gambar baru dengan ukuran yang sudah disesuaikan
            $newImage = imagescale($img, $width, $height);

            // Tentukan kualitas kompresi (mulai dari 90, bisa diatur)
            $compressionQuality = 90;

            // Simpan sementara gambar dengan kualitas tinggi
            $tempPath = public_path('temp/temp_image.jpg');
            imagejpeg($newImage, $tempPath, $compressionQuality);

            // Cek ukuran gambar dan turunkan kualitas jika lebih besar dari 200KB
            while (filesize($tempPath) > 200 * 1024 && $compressionQuality > 10) {
                $compressionQuality -= 5; // Menurunkan kualitas kompresi sedikit-sedikit
                imagejpeg($newImage, $tempPath, $compressionQuality);
            }

            // Pindahkan file sementara ke folder 'temp'
            if (rename($tempPath, public_path($imagePath))) {
                // Gambar berhasil dipindahkan
                // Menyimpan gambar yang sudah diproses dengan kualitas kompresi yang diatur
                $dbImage = Image::create([
                    'original_name' => $image->getClientOriginalName(),
                    'compressed_name' => $imageName,
                    'path' => $imagePath,
                ]);

                // Menyimpan informasi gambar ke dalam array
                $images[] = [
                    'id' => $dbImage->id, // Menyimpan ID dari database untuk referensi
                    'original_name' => $image->getClientOriginalName(),
                    'path' => $imagePath,
                ];

                // Bersihkan memory
                imagedestroy($img);
                imagedestroy($newImage);
            } else {
                // Log error jika rename gagal
                Log::error("Gagal memindahkan gambar ke folder temp: " . $imageName);
            }
        }

        // Mengirimkan kembali data ke tampilan
        return view('tools.Kompres.ImageCompres', compact('title', 'arr_ths', 'breadcrumb', 'images'));
    }



    // Mengunduh gambar yang telah dikompresi
    public function download($id)
    {
        // Misalnya, kita mencari gambar berdasarkan ID
        $image = Image::find($id); // Pastikan kamu mengakses gambar dari database atau sistem file yang benar

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        // Path gambar
        $filePath = public_path($image->path);

        if (!File::exists($filePath)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        // Mengembalikan file untuk diunduh
        return response()->download($filePath);
    }
    public function deleteSelected(Request $request)
    {
        $request->validate([
            'delete_ids' => 'required|array', // Pastikan ada id gambar yang dipilih
            'delete_ids.*' => 'exists:images,id' // Validasi apakah id gambar ada di database
        ]);

        $deleteIds = $request->input('delete_ids');
        $images = Image::whereIn('id', $deleteIds)->get();


        foreach ($images as $image) {
            $path = public_path($image->path);

            if (file_exists($path)) {
                unlink($path);
            }

            $image->delete();
        }

        // dd($request->all(), $images);
        // dd($request->all());
        return redirect()->route('image.index')->with('success', 'Gambar berhasil dihapus.');
    }


    public function downloadAll()
    {
        $images = Image::all(); // Ambil semua data gambar

        $zip = new ZipArchive;
        $fileName = public_path('compressed_images.zip');

        if ($zip->open($fileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($images as $image) {
                $path = public_path($image->path);
                if (file_exists($path)) {
                    $zip->addFile($path, basename($path));
                }
            }
            $zip->close();
        }

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
