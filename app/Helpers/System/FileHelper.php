<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Http\UploadedFile;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;
/*
        |--------------------------------------------------------------------------
        | 📌 FileHelper :
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - Menggandakan file di temp ke folder tertentu
        | - xxxxxxxxxxx
        |
        | Tujuan :
        | - xxxxxxxxxxx
        |
        | Penggunaan :
        | - xxxxxxxxxxx
        |
    */

// Proses Coding
if (!function_exists('CopyFileWa')) {
    /**
     * Menyalin file dari public/temp ke whatsapp/uploads (di luar public)
     *
     * @param string $namaFile Nama file (contoh: sertifikat.pdf)
     * @return array ['status' => 'success|error', 'message' => string]
     */
    function CopyFileWa(string $namaFile, $folder = 'temp'): array
    {
        $sourcePath = public_path($folder . '/' . $namaFile);  // sumber
        $targetPath = base_path('whatsapp/uploads/' . $namaFile); // target

        if (!file_exists($sourcePath)) {
            return ['status' => 'error', 'message' => "File '$namaFile' tidak ditemukan di $folder"];
        }

        if (!is_dir(dirname($targetPath))) {
            mkdir(dirname($targetPath), 0775, true);
        }

        if (!copy($sourcePath, $targetPath)) {
            return ['status' => 'error', 'message' => 'Gagal menyalin file'];
        }

        return ['status' => 'success', 'message' => "File berhasil disalin ke whatsapp/uploads/$namaFile"];
    }
}
/*
Skenario file public/temp dicopy ke whatsapp/uploads
skenario lanjutan kirim ke no tujuan
$namaFile = 'fileinjec';
        $hasil = CopyFileWa($namaFile . '.pdf');
        $pdf_to_jpg = pdf_to_image_wa($namaFile); // => 'abc123'
*/

/*
    |--------------------------------------------------------------------------
    | 📌 UplaodFile :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - Mengatur tempat upload file
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - Memudahkan untuk upload file
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
    $filename = 'rapor_' . time() . '.' . $file->getClientOriginalExtension();
    $path = upload_file_to($file, $filename, 'uploads/rapor');
    */
/*
        // Copy file
        $result = copy_file('uploads/file1.pdf', 'backup/file1.pdf');
        echo $result['message'];

        // Move file
        $result = move_file('uploads/file1.pdf', 'archive/file1.pdf');
        echo $result['message'];

    */

if (!function_exists('UploadFiles')) {
    /**
     * Upload file ke folder tertentu dengan nama custom
     *
     * @param UploadedFile $file
     * @param string $filename Nama file (termasuk extension)
     * @param string $folder Path folder relatif dari storage/app/public
     * @return string Path lengkap yang disimpan
     */
    function UploadFiles(UploadedFile $file, string $filename, string $folder = 'uploads'): string
    {
        $path = $folder . '/' . $filename;
        $file->storeAs('public/' . $folder, $filename);
        return 'storage/' . $path;
    }
}
/*
        cara pakai copy file
        $source = public_path('images/logo.png');
        $destination = public_path('dokumen/siswa/12345/logo.png');

        $result = copy_file($source, $destination);
    */
if (!function_exists('copy_file')) {
    /**
     * Copy file dari sumber ke tujuan
     *
     * @param string $source Path file asal
     * @param string $destination Path tujuan
     * @return array ['success' => bool, 'message' => string]
     */
    function copy_file(string $source, string $destination): array
    {
        if (!file_exists($source)) {
            return ['success' => false, 'message' => 'File sumber tidak ditemukan.'];
        }

        $dir = dirname($destination);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true)) {
                return ['success' => false, 'message' => 'Gagal membuat folder tujuan.'];
            }
        }

        if (copy($source, $destination)) {
            return ['success' => true, 'message' => 'File berhasil dicopy.'];
        }

        return ['success' => false, 'message' => 'Gagal menyalin file.'];
    }
}
if (!function_exists('move_file')) {
    /**
     * Pindahkan file dari sumber ke tujuan
     *
     * @param string $source Path file asal
     * @param string $destination Path tujuan
     * @return array ['success' => bool, 'message' => string]
     */
    /*
    // Cek apakah gambar profile ada
        if (file_exists_in_dir('uploads/profile', 'user123.jpg')) {
            echo "Profile user sudah ada.";
        } else {
            echo "Profile user belum ada, gunakan default.jpg";
        }
    */
    function move_file(string $source, string $destination): array
    {
        if (!file_exists($source)) {
            return ['success' => false, 'message' => 'File sumber tidak ditemukan.'];
        }

        $dir = dirname($destination);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true)) {
                return ['success' => false, 'message' => 'Gagal membuat folder tujuan.'];
            }
        }

        if (rename($source, $destination)) {
            return ['success' => true, 'message' => 'File berhasil dipindahkan.'];
        }

        return ['success' => false, 'message' => 'Gagal memindahkan file.'];
    }
}

/*
    |--------------------------------------------------------------------------
    | 📌 Cek File Exist :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
    */
// Proses Coding
if (!function_exists('CekFileExists')) {
    /**
     * Cek apakah file ada di folder public.
     * Jika ada, kembalikan URL asset, jika tidak kembalikan fallback.
     *
     * @param string $pathPublic Path relatif dari folder public
     * @param string|null $fallback Optional, URL fallback jika file tidak ada
     * @return string URL file yang valid
     * $dataGambar = CekFileExists('img/foto.png'); // Cek file, otomatis fallback kalau tidak ada
     */
    function CekFileExists(string $pathPublic, string $fallback = 'img/default.png'): string
    {
        $fullPath = public_path($pathPublic);

        if (file_exists($fullPath)) {
            return asset($pathPublic);
        }

        return asset($fallback);
    }
}

function HapusFile($pathPublic)
{
    $fullPath = public_path($pathPublic);
    if (file_exists($fullPath)) {
        unlink($fullPath);
        return true;
    }
    return false;
}
// function ListFile($folder = 'uploads', $ext = null)
// {
//     $path = public_path($folder);
//     if (!is_dir($path)) return [];

//     $files = scandir($path);
//     $files = array_filter($files, fn($f) => !in_array($f, ['.', '..']));

//     if ($ext) {
//         $files = array_filter($files, fn($f) => pathinfo($f, PATHINFO_EXTENSION) === $ext);
//     }

//     return array_map(fn($f) => asset("$folder/$f"), $files);
// }
function DownloadFile($pathPublic, $name = null)
{
    $fullPath = public_path($pathPublic);
    if (file_exists($fullPath)) {
        return response()->download($fullPath, $name ?? basename($fullPath));
    }
    abort(404, 'File tidak ditemukan.');
}
/*
    |--------------------------------------------------------------------------
    | 📌 Run Bat :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
        $result = run_bat('whatsapp/setup.bat');
        if (!$result['success']) {
            die("Error menjalankan setup.bat: " . implode("\n", $result['output']));
        }
    |
    */
// Proses Coding
if (!function_exists('run_bat')) {
    /**
     * Jalankan file .bat
     *
     * @param string $relativePath Path relatif dari base_path
     * @return array ['success' => bool, 'output' => array, 'return_var' => int]
     * penggunaakn
     *
     */
    function run_bat(string $relativePath)
    {
        $fullPath = base_path($relativePath);
        // $batFile = base_path('executor/whatsapp/serverjs.exe');
        pclose(popen("start \"\" \"$fullPath\"", "r"));
        if (!file_exists($fullPath)) {
            return [
                'success' => false,
                'output' => ["File .bat tidak ditemukan: $fullPath"],
                'return_var' => -1,
            ];
        }
        // // Jalankan lewat CMD biar aman
        // exec('cmd /c "' . $fullPath . '"', $output, $return_var);
        return [
            'success' => 'File Telah Di jalankan',
            'path' => $fullPath,
        ];
    }
}
// penunjang runbating untuk output whatsapp
if (!function_exists('parse_service_output')) {
    /**
     * Parse hasil `sc query` jadi array [namaService => status]
     *
     * @param array $lines Hasil output dari exec() atau run_bat()
     * @return array
     */
    function parse_service_output(array $lines): array
    {
        $services = [];
        $current = null;

        foreach ($lines as $line) {
            if (strpos($line, 'SERVICE_NAME:') !== false) {
                $current = trim(str_replace('SERVICE_NAME:', '', $line));
                $services[$current] = 'UNKNOWN';
            }

            if (strpos($line, 'STATE') !== false && $current) {
                if (strpos($line, '4  RUNNING') !== false) {
                    $services[$current] = 'RUNNING';
                } elseif (strpos($line, '1  STOPPED') !== false) {
                    $services[$current] = 'STOPPED';
                }
            }
        }

        return $services;
    }
}

function run_bating(string $relativePath): array
{
    $fullPath = base_path($relativePath);

    if (!file_exists($fullPath)) {
        return [
            'success' => false,
            'output' => ["File .bat tidak ditemukan: $fullPath"],
            'return_var' => -1,
        ];
    }

    $command = 'cmd /c "' . $fullPath . '"';
    exec($command . ' 2>&1', $output, $return_var);

    return [
        'success' => $return_var === 0,
        'command' => $command,
        'output' => $output,
        'return_var' => $return_var,
    ];
}

/*
    |--------------------------------------------------------------------------
    | 📌 Download GitHub :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
     $result = download_github_file(
            'username/repo',       // repo
            'main',                // branch
            'path/to/file.txt',    // file di repo
            storage_path('file.txt') // simpan lokal
        );

        if ($result !== true) {
            echo "Download gagal: " . $result;
        } else {
            echo "File berhasil di-download!";
        }

    */
// Proses Coding
if (!function_exists('download_github_file')) {
    /**
     * Download file dari GitHub
     *
     * @param string $repoFullName Contoh: "user/repo"
     * @param string $branch Contoh: "main"
     * @param string $filePath Path file di repo
     * @param string $saveTo Path lokal untuk simpan file
     * @return bool|string True jika sukses, error message jika gagal
     */
    function download_github_file(string $repoFullName, string $branch, string $filePath, string $saveTo)
    {
        // URL raw GitHub
        $url = "https://raw.githubusercontent.com/{$repoFullName}/{$branch}/{$filePath}";

        try {
            $response = Http::get($url);

            if ($response->failed()) {
                return "Gagal download file, status: " . $response->status();
            }

            file_put_contents($saveTo, $response->body());

            return true;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Extrak Zip :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
    // Extract ZIP
        $result = extract_zip(storage_path('file.zip'), storage_path('extracted'));
        if ($result !== true) {
            echo "Gagal extract: $result";
        }
    */
// Proses Coding
if (!function_exists('extract_zip')) {
    /**
     * Extract ZIP file ke folder tujuan
     *
     * @param string $zipPath Path file ZIP
     * @param string $extractTo Folder tujuan extract
     * @return bool|string True jika sukses, error message jika gagal
     */
    function extract_zip(string $zipPath, string $extractTo)
    {
        if (!file_exists($zipPath)) {
            return "File ZIP tidak ditemukan: $zipPath";
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath) === true) {
            $zip->extractTo($extractTo);
            $zip->close();
            return true;
        } else {
            return "Gagal membuka file ZIP: $zipPath";
        }
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Creat Zip :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |


        // Create ZIP
        $result = create_zip(storage_path('myfolder'), storage_path('myfolder.zip'));
        if ($result !== true) {
            echo "Gagal membuat ZIP: $result";
        }
    */
// Proses Coding
if (!function_exists('create_zip')) {
    /**
     * Buat ZIP dari folder tertentu
     *
     * @param string $folderPath Folder yang akan di-zip
     * @param string $zipPath Path ZIP yang akan dibuat
     * @return bool|string True jika sukses, error message jika gagal
     */
    function create_zip(string $folderPath, string $zipPath)
    {
        if (!is_dir($folderPath)) {
            return "Folder tidak ditemukan: $folderPath";
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return "Gagal membuat ZIP: $zipPath";
        }

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folderPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folderPath) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
        return true;
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 JalanKan Perintah cmd / bat :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    $folder = 'C:/laragon_instaler/www/whatsapp';
    $commands = [
        "npm install",
        "npm run build"
    ];

    $result = runCommands($commands, $folder);

    if ($result['success']) {
        echo "Semua command berhasil:\n";
        print_r($result['output']);
    } else {
        echo "Gagal di command: " . $result['failed_command'] . "\n";
        print_r($result['output']);
    }

    |
    */
// Proses Coding
if (!function_exists('runCommands')) {
    /**
     * Jalankan beberapa command shell secara berurutan
     *
     * @param array $commands Array perintah shell
     * @param string|null $workingDir Folder kerja (opsional)
     * @return array ['success' => bool, 'output' => array, 'failed_command' => string|null]
     */
    function runCommands(array $commands, string $workingDir = null): array
    {
        if ($workingDir) {
            if (!is_dir($workingDir)) {
                return [
                    'success' => false,
                    'output' => ["Folder $workingDir tidak ada!"],
                    'failed_command' => null
                ];
            }
            chdir($workingDir);
        }

        $allOutput = [];

        foreach ($commands as $cmd) {
            exec($cmd, $output, $return_var);
            $allOutput = array_merge($allOutput, $output);
            $output = []; // reset output

            if ($return_var !== 0) {
                return [
                    'success' => false,
                    'output' => $allOutput,
                    'failed_command' => $cmd
                ];
            }
        }

        return [
            'success' => true,
            'output' => $allOutput,
            'failed_command' => null
        ];
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Database :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
    */
// Proses Coding
if (!function_exists('backup_database')) {

    /**
     * Backup database MySQL ke file .sql
     *
     * Fungsi ini akan:
     * 1. Membuat folder tujuan jika belum ada
     * 2. Menyusun nama file backup berdasarkan timestamp (default: backup-Ymd-His.sql)
     * 3. Menjalankan `mysqldump` untuk membuat backup
     * 4. Mengembalikan status sukses/gagal, path file, dan pesan
     *
     * @param string|null $targetDirectory Folder tujuan backup. Default: storage/backups/sql
     * @param string|null $filename Nama file backup. Default: backup-Ymd-His.sql
     * @return array ['success' => bool, 'path' => string|null, 'message' => string]
     *
     * @example
     * $result = backup_database(storage_path('backups/sql'));
     * if ($result['success']) {
     *     echo $result['message'];
     * }
     */
    function backup_database(string $targetDirectory = null, string $filename = null): array
    {
        // Tentukan folder tujuan
        $targetDirectory = $targetDirectory ?? storage_path('backups/sql');

        // Buat folder jika belum ada
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        // Tentukan nama file backup
        $filename = $filename ?? 'backup-' . now()->format('Ymd-His') . '.sql';
        $path = $targetDirectory . '/' . $filename;

        // Ambil konfigurasi database dari .env
        $db   = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');

        // Susun command mysqldump
        // escapse shell untuk menghindari karakter berbahaya
        $command = sprintf(
            'mysqldump -u%s -p"%s" -h%s %s > %s',
            escapeshellarg($user),
            escapeshellarg($pass),
            escapeshellarg($host),
            escapeshellarg($db),
            escapeshellarg($path)
        );

        // Jalankan command
        exec($command, $output, $status);

        // Cek hasil
        if ($status === 0 && file_exists($path)) {
            return [
                'success' => true,
                'path' => $path,
                'message' => "✅ Backup berhasil: $filename",
            ];
        }

        return [
            'success' => false,
            'path' => null,
            'message' => "❌ Backup gagal. Periksa apakah `mysqldump` tersedia dan kredensial benar.",
        ];
    }
}

if (!function_exists('download_backup')) {

    /**
     * Buat response untuk download file backup
     *
     * Fungsi ini akan:
     * 1. Mengecek apakah file backup ada
     * 2. Mengembalikan response Laravel untuk di-download
     *
     * @param string $filePath Path file backup
     * @param string|null $downloadName Nama file saat didownload (opsional)
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\Response
     *
     * @example
     * Route::get('/download-backup', function () use ($result) {
     *     return download_backup($result['path']);
     * });
     */
    function download_backup(string $filePath, string $downloadName = null)
    {
        if (!file_exists($filePath)) {
            abort(404, "File backup tidak ditemukan");
        }

        // Gunakan response()->download bawaan Laravel
        return response()->download($filePath, $downloadName ?? basename($filePath));
    }
}
if (!function_exists('restore_database')) {

    /**
     * Restore database MySQL dari file .sql
     *
     * Fungsi ini akan:
     * 1. Mengecek apakah file backup ada
     * 2. Menjalankan `mysql` untuk merestore database
     * 3. Mengembalikan status sukses/gagal dan pesan
     *
     * @param string $filePath Path file .sql backup
     * @return array ['success' => bool, 'message' => string]
     *
     * @example
     * $result = restore_database(storage_path('backups/sql/backup-20250905-123456.sql'));
     * if ($result['success']) {
     *     echo $result['message'];
     * } else {
     *     echo $result['message'];
     * }
     */
    function restore_database(string $filePath): array
    {
        if (!file_exists($filePath)) {
            return [
                'success' => false,
                'message' => "❌ File backup tidak ditemukan: $filePath",
            ];
        }

        // Ambil konfigurasi database dari .env
        $db   = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');

        // Susun command mysql untuk restore
        $command = sprintf(
            'mysql -u%s -p"%s" -h%s %s < %s',
            escapeshellarg($user),
            escapeshellarg($pass),
            escapeshellarg($host),
            escapeshellarg($db),
            escapeshellarg($filePath)
        );

        // Jalankan command
        exec($command, $output, $status);

        if ($status === 0) {
            return [
                'success' => true,
                'message' => "✅ Restore database berhasil dari file: " . basename($filePath),
            ];
        }

        return [
            'success' => false,
            'message' => "❌ Restore gagal. Periksa kredensial dan file backup.",
        ];
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Get Serial Disk :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
    */
// Proses Coding
if (!function_exists('get_disk_serial')) {
    /**
     * Ambil Serial Number Hard Disk (Windows)
     */
    function get_disk_serial(): ?string
    {
        $serial = null;

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $output = null;
            $retval = null;

            exec('wmic diskdrive where "Index=0" get SerialNumber /format:list', $output, $retval);

            if ($retval === 0 && !empty($output)) {
                foreach ($output as $line) {
                    if (str_contains($line, 'SerialNumber=')) {
                        $serial = trim(str_replace('SerialNumber=', '', $line));
                        break;
                    }
                }
            }
        }

        return $serial;
    }
}
// jika lebih dari 1
if (!function_exists('get_disk_serials')) {
    /**
     * Ambil Serial Number Semua Hard Disk (Windows) dalam format string "xxxx - xxxx - xxxx"
     * @return string|null
     */
    function get_disk_serials(): ?string
    {
        $serials = [];

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $output = null;
            $retval = null;

            // Ambil semua disk
            exec('wmic diskdrive get SerialNumber /format:list', $output, $retval);

            if ($retval === 0 && !empty($output)) {
                foreach ($output as $line) {
                    if (str_contains($line, 'SerialNumber=')) {
                        $serial = trim(str_replace('SerialNumber=', '', $line));
                        if ($serial !== '') {
                            $serials[] = $serial;
                        }
                    }
                }
            }
        }

        // Gabungkan semua serial dengan " - "
        return !empty($serials) ? implode(' - ', $serials) : null;
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Zip :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |

        // Contoh penggunaan
       // Zip semua PNG di folder default
        $zipFile = zipFolder();

        // Zip semua JPG di folder custom
        $zipFile = zipFolder('foto_siswa.zip', base_path('public/img/foto-siswa'), 'jpg');

    */
// Proses Coding
if (!function_exists('zipFolder')) {
    /**
     * Zip semua file di folder tertentu
     *
     * @param string|null $zipName Nama file zip, default YYYY-MM-DD.zip
     * @param string|null $folderPath Path folder yang ingin di-zip, default base_path('public/img/kartu-pembarayan')
     * @param string $extension Hanya zip file dengan ekstensi tertentu (misal 'png'), default semua
     * @return string|false Path file zip yang dibuat, false jika gagal
     */
    function zipFolder($zipName = null, $folderPath = null, $extension = '*')
    {
        $folderPath = $folderPath ?? base_path('public/img/kartu-pembarayan');
        $zipName = $zipName ?? date('Y-m-d') . '.zip';
        $zipPath = $folderPath . '/' . $zipName;

        $files = glob($folderPath . "/*.$extension");
        if (!$files) return false;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return false;
        }

        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }

        $zip->close();

        return $zipPath;
    }
}
// SVG To Base64
if (!function_exists('svgtobase64')) {
    /**
     * Convert SVG file or string to Base64
     *
     * @param string $svgPathOrContent File path or raw SVG content
     * @param bool $isFile Set true if parameter is file path
     * @return string
     */
    function svgtobase64(string $svgPathOrContent, bool $isFile = true): string
    {
        $svgContent = $isFile ? file_get_contents($svgPathOrContent) : $svgPathOrContent;
        $base64 = base64_encode($svgContent);
        return 'data:image/svg+xml;base64,' . $base64;
    }
}

if (!function_exists('run_task')) {
    function run_task($taskName)
    {
        /*
        |--------------------------------------------------------------------------
        | 📌 Catatan Penggunaan Scheduled Task (Windows) / Task Schedule
        |--------------------------------------------------------------------------
        |
        | 1️⃣ Cara membuat task restart PC:
        |     schtasks /Create /TN "RestartPC" ^
        |         /TR "C:\Windows\System32\shutdown.exe /r /t 0" ^
        |         /SC ONCE /ST 00:00 /RL HIGHEST /RU SYSTEM /F
        Gunakan cmd :
        schtasks /Create /TN "RestartPC" /TR "C:\Windows\System32\shutdown.exe /r /t 0" /SC ONCE /ST 00:00 /RL HIGHEST /RU SYSTEM /F
        schtasks /Create /TN "RestartPC" /TR "C:\laragon\www\siakad\executor\pc\restart_komputer.exe" /SC ONCE /ST 00:00 /RL HIGHEST /RU SYSTEM /F
        mode daily
        schtasks /Create /TN "RestartPC" /TR "C:\laragon\www\siakad\executor\pc\restart_komputer.exe" /SC DAILY /ST 14:00 /RL HIGHEST /RU SYSTEM /F



        |     - /TN       → Nama task ("RestartPC")
        |     - /TR       → Perintah yang dijalankan (shutdown restart)
        |     - /SC ONCE  → Jadwal sekali jalan (harus ada /ST)
        |     - /ST 00:00 → Start time dummy (task tetap bisa run manual)
        |     - /RL       → Run Level (HIGHEST = run as admin)
        |     - /RU SYSTEM→ Jalan pakai akun SYSTEM
        |     - /F        → Force overwrite kalau sudah ada
        |
        | 2️⃣ Cara menjalankan task bat:
        |     schtasks /Run /TN "RestartPC"
        |
        | 3️⃣ Jalankan lewat PHP:
             exec('schtasks /Run /TN "RestartPC" 2>&1', $output, $status);
             if ($status === 0) {
                 $this->info("✅ Restart sukses");
             } else {
                 $this->error("❌ Gagal: " . implode("\n", $output));
             }
        |
        | 4️⃣ Cara cek detail task di Windows:
        |     schtasks /Query /TN "RestartPC" /V /FO LIST
        |
        |   - /V  → verbose (detail info)
        |   - /FO → format output (LIST, TABLE, CSV)
        |
        |--------------------------------------------------------------------------
        */

        $command = 'schtasks /Run /TN "' . $taskName . '" 2>&1';
        exec($command, $output, $status);

        return [
            'status' => $status,
            'output' => $output,
            'command' => $command
        ];
    }
}

/*
|------------------------------------------------------------------------------
| 📌 Catatan Penggunaan Scheduled Task (Windows) / Task Scheduler
|------------------------------------------------------------------------------
|
| 1️⃣ Cara membuat task restart PC (sekali jalan, bisa dipanggil manual):
|     schtasks /Create /TN "RestartPC" ^
|         /TR "C:\Windows\System32\shutdown.exe /r /t 0" ^
|         /SC ONCE /ST 00:00 /RL HIGHEST /RU SYSTEM /F
|
| 2️⃣ Cara membuat task restart PC (otomatis setiap hari jam 14:00):
|     schtasks /Create /TN "RestartPC" ^
|         /TR "C:\Windows\System32\shutdown.exe /r /t 0" ^
|         /SC DAILY /ST 14:00 /RL HIGHEST /RU SYSTEM /F
|
| 3️⃣ Cara menjalankan task secara manual:
|     schtasks /Run /TN "RestartPC"
|
| 4️⃣ Cara cek detail task:
|     schtasks /Query /TN "RestartPC" /V /FO LIST
|
| 5️⃣ Catatan:
|     - Gunakan Laragon/Terminal dalam mode Administrator
|     - Jika /RU SYSTEM dipakai → bisa jalan tanpa login user
|
*/

if (!function_exists('create_task')) {
    /**
     * Membuat Scheduled Task Windows via schtasks
     *
     * @param string      $taskName Nama task (contoh: RestartPC)
     * @param string      $pathFile Path file exe/bat yang akan dijalankan
     * @param string|null $daily    Jam harian, contoh "14:00".
     *                              Jika null → mode sekali jalan (ONCE, jam 00:00).
     * @return array
     */
    function create_task($taskName, $pathFile, $daily = null)
    {
        $taskName = escapeshellarg($taskName);
        $pathFile = escapeshellarg($pathFile);

        if ($daily) {
            // Mode harian
            $command = "schtasks /Create /TN $taskName /TR $pathFile /SC DAILY /ST $daily /RL HIGHEST /RU SYSTEM /F";
        } else {
            // Mode sekali jalan
            $command = "schtasks /Create /TN $taskName /TR $pathFile /SC ONCE /ST 00:00 /RL HIGHEST /RU SYSTEM /F";
        }

        exec($command . " 2>&1", $output, $status);

        return [
            'command' => $command,
            'status'  => $status,
            'output'  => $output
        ];
    }
}

// Konversi docx ke pdf dengan dompdf
/*
$docx = storage_path('app/templates/surat.docx');
$pdf  = storage_path('app/public/surat.pdf');

$hasil = docx_to_pdf($docx, $pdf);

dd("PDF tersimpan di: {$hasil}");

*/
if (!function_exists('docx_to_pdf')) {
    /**
     * Convert DOCX ke PDF
     *
     * @param string $inputDocx  full path .docx
     * @param string|null $outputPdf full path .pdf (default: sama nama dengan .docx)
     * @return string path pdf hasil konversi
     */
    function docx_to_pdf(string $inputDocx, ?string $outputPdf = null): string
    {
        if (!file_exists($inputDocx)) {
            throw new \Exception("File DOCX tidak ditemukan: {$inputDocx}");
        }

        // Tentukan output default
        if (!$outputPdf) {
            $outputPdf = preg_replace('/\.docx$/i', '.pdf', $inputDocx);
        }

        // Load DOCX
        $phpWord = IOFactory::load($inputDocx);

        // Export ke HTML
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        ob_start();
        $htmlWriter->save('php://output');
        $html = ob_get_clean();

        // Convert ke PDF
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
        $pdf->save($outputPdf);

        return $outputPdf;
    }
}
// docx isi
// use PhpOffice\PhpWord\TemplateProcessor;

if (!function_exists('fill_docx_template')) {
    /**
     * Isi template DOCX dengan data lalu simpan ke output
     *
     * @param string $templatePath  Path ke file template .docx
     * @param array $data           Data key => value
     * @param string $outputPath    Path output .docx
     * @return string Path file hasil
     */
    // cara penggunaan
    /*
        $data = [
            'nama'    => 'Budi Santoso',
            'jabatan' => 'Kepala Sekolah',
            'tanggal' => date('d F Y'),
        ];

        $hasil = fill_docx_template(
            storage_path('templates/surat.docx'),
            $data,
            storage_path('app/public/surat-aktif.docx')
        );

        dd("✅ DOCX berhasil dibuat di: {$hasil}");
    */
    function fill_docx_template(string $templatePath, array $data, string $outputPath): string
    {
        if (!file_exists($templatePath)) {
            throw new \Exception("Template tidak ditemukan: {$templatePath}");
        }

        $template = new TemplateProcessor($templatePath);

        foreach ($data as $key => $value) {
            $template->setValue($key, $value);
        }

        $template->saveAs($outputPath);

        return $outputPath;
    }
}
/*
 * Isi template DOCX dengan data lalu simpan ke output
 *
 * - Value biasa (string/number) => langsung diganti dengan setValue
 * - Array multidimensi          => dianggap tabel, diganti dengan cloneRowAndSetValues
 * - Gambar (path / array)       => diproses dengan setImageValue
 *
 * ---------------------------------
 *
 * Cara penggunaan:
 *
 */
/* $data = [
      // Value biasa
      'nama'    => 'Budi Santoso',
      'jabatan' => 'Kepala Sekolah',
      'tanggal' => date('d F Y'),

      // Gambar (path langsung)
      'foto'    => public_path('uploads/foto_budi.jpg'),

      // Gambar (detail setting)
      'ttd'     => [
          'path'   => public_path('uploads/ttd.png'),
          'width'  => 120,
          'height' => 80,
          'ratio'  => true,
      ],

      // Tabel (multi-row)
      'lomba'   => [
          [
              'lomba'   => 'LCC',
              'juara'   => 'Juara 1',
              'tingkat' => 'Kecamatan',
          ],
          [
              'lomba'   => 'Cerdas Cermat',
              'juara'   => 'Juara 2',
              'tingkat' => 'Kabupaten',
          ],
          [
              'lomba'   => 'Debat',
              'juara'   => 'Juara Harapan',
              'tingkat' => 'Provinsi',
          ],
      ],
  ];

  $hasil = fill_docx_template(
      storage_path('templates/surat.docx'),
      $data,
      storage_path('app/public/surat-aktif.docx')
  );

  dd("✅ DOCX berhasil dibuat di: {$hasil}");
*/

if (!function_exists('fill_docx_template_complex')) {
    function fill_docx_template_complex(string $templatePath, array $data, string $outputPath): string
    {
        if (!file_exists($templatePath)) {
            throw new \Exception("Template tidak ditemukan: {$templatePath}");
        }

        $template = new TemplateProcessor($templatePath);

        foreach ($data as $key => $value) {
            // === Handle TABEL (array multidimensi) ===
            if (is_array($value) && isset($value[0]) && is_array($value[0])) {
                // ambil key pertama dari array anak
                $firstChildKey = array_key_first($value[0]);
                $template->cloneRowAndSetValues($firstChildKey, $value);

                // === Handle GAMBAR (array config) ===
            } elseif (is_array($value) && isset($value['path'])) {
                $imgOptions = array_merge([
                    'width'  => 100,
                    'height' => 100,
                    'ratio'  => true,
                ], $value);

                $template->setImageValue($key, $imgOptions);

                // === Handle GAMBAR (path langsung) ===
            } elseif (is_string($value) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $value) && file_exists($value)) {
                $template->setImageValue($key, [
                    'path'   => $value,
                    'width'  => 100,
                    'height' => 100,
                    'ratio'  => true,
                ]);

                // === Handle VALUE biasa ===
            } else {
                $template->setValue($key, $value);
            }
        }

        $template->saveAs($outputPath);

        return $outputPath;
    }
}

// Helper Hapus file setelah kirim wa
if (!function_exists('hapusFileWhatsApp')) {
    function hapusFileWhatsApp($RootFileBasePath, $filename)
    {
        //Isi Fungsi
        clearstatcache();
        if (file_exists($RootFileBasePath)) {
            if (unlink($RootFileBasePath)) {
                $cek = "✅ File {$filename} berhasil dihapus";
            } else {
                $cek = "⚠️ Gagal hapus file {$filename}, cek permission";
            }
        } else {
            $cek = "⚠️ File {$filename} tidak ditemukan di {$RootFileBasePath}";
        }
        // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $cek);
    }
}
