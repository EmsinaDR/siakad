<?php


use Carbon\Carbon;
use setasign\Fpdi\Fpdi;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\FacadesLog;
use Illuminate\Support\Facades\Log;
use App\Models\User\Guru\Detailguru;

use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use PhpOffice\PhpWord\IOFactory as WordIO;
use PhpOffice\PhpSpreadsheet\IOFactory as SheetIO;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf as SheetPdf;

if (!function_exists('ambilNamaSiswa')) {
    function ambilNamaSiswa($SiswaIds)
    {
        // Kalau bentuknya string JSON, decode dulu
        if (is_string($SiswaIds)) {
            $SiswaIds = json_decode($SiswaIds, true); // hasilnya array
        }

        // Kalau hasil decode bukan array (atau null), kasih fallback
        if (!is_array($SiswaIds) || count($SiswaIds) === 0) {
            return "<ul><li><em>Tidak ada Siswa terdaftar</em></li></ul>";
        }

        $namaSiswas = Detailsiswa::whereIn('id', $SiswaIds)->pluck('nama_Siswa');

        return "<ul>" . $namaSiswas->map(fn($nama) => "<li>{$nama}</li>")->implode('') . "</ul>";
    }
}
if (!function_exists('umursiswa')) {
    /**
     * Menghitung umur dari tanggal lahir.
     *
     * @param string|Carbon $tanggal_lahir
     * @return int|null
     */
    function umursiswa($tanggal_lahir)
    {
        if (!$tanggal_lahir) return null;

        return Carbon::parse($tanggal_lahir)->age;
    }
}
if (!function_exists('kelassiswa')) {
    /**
     * Mengambil nama kelas aktif siswa berdasarkan ID.
     *
     * @param int $siswaId
     * @return string|null
     */
    function kelassiswa($siswaId)
    {
        if (!$siswaId) return null;

        $detail = Detailsiswa::with('KelasOne')
            ->where('id', $siswaId)
            ->first();

        return $detail?->KelasOne?->kelas ?? '-';
    }
}
if (!function_exists('DataSiswaAlly')) {
    /**
     * Mengambil data siswa lengkap dari NIS.
     *
     */
    function DataSiswaAlly($nis)
    {
        $Siswa = Detailsiswa::with('KelasOne')->where('nis', $nis)->first();

        $data = [
            'nama_siswa' => $Siswa->nama_siswa ?? '-',
            'kelas' => $Siswa->KelasOne->kelas ?? '-',
            'alamat_siswa' => $Siswa->alamat_siswa ?? '-',
            'nama_ortu' => $Siswa->ayah_nama ?? '-',
        ];

        return $data;
    }
}
if (!function_exists('getSiswaAktif')) {
    /**
     * Mengambil data siswa aktif yang memiliki kelas_id (tidak null).
     *
     * @param array $excludeIds Optional, daftar ID siswa yang ingin dikecualikan
     * @param int|null $limit Optional, jumlah maksimum siswa yang ingin diambil
     * @return \Illuminate\Support\Collection
     *
     * Contoh Penggunaan:
     * --------------------------------------
     * // Ambil semua siswa aktif
     * $semuaSiswa = getSiswaAktif();
     *
     * // Ambil semua siswa aktif kecuali ID 1,2,3
     * $siswaFiltered = getSiswaAktif([1,2,3]);
     *
     * // Ambil maksimal 5 siswa aktif
     * $top5Siswa = getSiswaAktif([], 5);
     *
     * // Ambil maksimal 5 siswa aktif kecuali ID 1,2,3
     * $top5Filtered = getSiswaAktif([1,2,3], 5);
     */
    function getSiswaAktif(array $excludeIds = [], ?int $limit = null)
    {
        // Buat query dasar: status_siswa = 'aktif' dan kelas_id tidak null
        $query = Detailsiswa::where('status_siswa', 'aktif')
            ->whereNotNull('kelas_id');

        // Jika ada ID yang ingin dikecualikan, tambahkan kondisi whereNotIn
        if (!empty($excludeIds)) {
            $query->whereNotIn('id', $excludeIds);
        }

        // Jika ada limit, ambil sejumlah itu saja
        if ($limit) {
            $query->take($limit);
        }

        // Ambil hasil query sebagai collection
        return $query->get();
    }
}
if (!function_exists('DataSIswaId')) {
    /**
     * Mengambil data siswa lengkap dari NIS.
     *
     */
    function DataSIswaId($id, $relations = [])
    {
        $Siswa = Detailsiswa::with($relations)->find($id);

        $tanggalLahir = $Siswa->tanggal_lahir
            ? Carbon::create($Siswa->tanggal_lahir)->translatedFormat('d F Y')
            : '-'; // atau 'Belum diisi' atau null

        $data = [
            'nama_siswa' => $Siswa->nama_siswa ?? '-',
            'nis' => $Siswa->nis ?? '-',
            'nisn' => $Siswa->nisn ?? '-',
            'kelas' => $Siswa->KelasOne->kelas ?? '-',
            'alamat_siswa' => $Siswa->alamat_siswa ?? '-',
            'nama_ortu' => $Siswa->ayah_nama ?? '-',
            'ayah_nama' => $Siswa->ayah_nama ?? '-',
            'ayah_pekerjaan' => $Siswa->ayah_nama ?? '-',
            'ayah_nohp' => $Siswa->ayah_nama ?? '-',
            'tempat_lahir' => $Siswa->tempat_lahir ?? '-',
            'tanggal_lahir' => $tanggalLahir ?? '-',
        ];

        return $data;
    }
}

if (!function_exists('DataSIswa')) {
    /**
     * Mengambil data siswa lengkap dari NIS.
     *
     */
    function DataSIswa($nis)
    {
        $Siswa = Detailsiswa::with('KelasOne')->where('nis', $nis)->first();

        $tanggalLahir = $Siswa->tanggalLahir
            ? Carbon::create($Siswa->tanggalLahir)->translatedFormat('d F Y')
            : '-'; // atau 'Belum diisi' atau null

        $data = [
            'nama_siswa' => $Siswa->nama_siswa ?? '-',
            'nis' => $Siswa->nis ?? '-',
            'nisn' => $Siswa->nisn ?? '-',
            'kelas' => $Siswa->KelasOne->kelas ?? '-',
            'alamat_siswa' => $Siswa->alamat_siswa ?? '-',
            'nama_ortu' => $Siswa->ayah_nama ?? '-',
            'ayah_nama' => $Siswa->ayah_nama ?? '-',
            'ayah_pekerjaan' => $Siswa->ayah_nama ?? '-',
            'ayah_nohp' => $Siswa->ayah_nama ?? '-',
            'tempat_lahir' => $Siswa->tempat_lahir ?? '-',
            'tanggal_lahir' => $tanggalLahir ?? '-',
        ];

        return $data;
    }
}
if (!function_exists('getSiswaByIds')) {
    /**
     * Mengambil data siswa aktif yang memiliki kelas_id (tidak null)
     * Hanya untuk ID yang ada di dalam array.
     *
     * @param array $includeIds Daftar ID siswa yang ingin diambil
     * @param int|null $limit Optional, jumlah maksimum siswa yang ingin diambil
     * @return \Illuminate\Support\Collection
     *
     * Contoh Penggunaan:
     * --------------------------------------
     * // Ambil siswa dengan ID 1,2,3
     * $siswa = getSiswaByIds([1,2,3]);
     *
     * // Ambil maksimal 5 siswa dari ID 1,2,3
     * $top5Siswa = getSiswaByIds([1,2,3], 5);
     */
    function getSiswaByIds(array $includeIds, ?int $limit = null)
    {
        $query = Detailsiswa::where('status_siswa', 'aktif')
            ->whereNotNull('kelas_id');

        if (!empty($includeIds)) {
            $query->whereIn('id', $includeIds);
        }

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }
}
if (!function_exists('cek_nohp_ortu')) {
    function cek_nohp_ortu($id, $noHp)
    {
        $siswa = Detailsiswa::select('ayah_nohp', 'ibu_nohp')
            ->where('id', $id)
            ->first();

        if (!$siswa) {
            return 'tidak ditemukan';
        }

        if ($siswa->ayah_nohp === $noHp) {
            return 'ayah';
        }

        if ($siswa->ibu_nohp === $noHp) {
            return 'ibu';
        }

        return 'bukan ortu';
    }
}
if (!function_exists('DokumenSiswa')) {
    function DokumenSiswa($sessions, $NoRequest, $message)
    {
        //Isi Fungsi
        $filename = 'contoh.jpg';
        $caption = 'Berikut ini dokumen yang diminta';
        $filePath = base_path('whatsapp/uploads/' . $filename);
        $kirim = \App\Models\Whatsapp\WhatsApp::sendMedia($sessions, $NoRequest, $caption, $filePath); // Tambahkan movefiel ke folderwhatsapp karena hanya bisa kirim via folder whatsapp

    }
}
// Kumpulan No HP ayah dan ibu
if (! function_exists('getAllNoHpSiswa')) {
    function getAllNoHpSiswa()
    {
        return Detailsiswa::pluck('ayah_nohp')
            ->merge(Detailsiswa::pluck('ibu_nohp'))
            ->filter(function ($nohp) {
                return !empty($nohp); // buang null & string kosong
            })
            ->unique()   // buang duplikat
            ->values()
            ->all();
    }
}
if (!function_exists('CopyDataSiswa')) {
    /**
     * Menyalin file data siswa dari public/folderAsal ke whatsapp/uploads/siswa
     * Jika file tidak ada maka gunakan default (blanko-foto)
     *
     * @param string $namaFile Nama file asli (contoh: foto_123.jpg)
     * @param string $folderAsal Folder asal dalam public (default: 'img/siswa')
     * @param string $defaultFile Nama file default jika file tidak ditemukan (contoh: 'blanko-foto.png')
     * @return array ['status' => 'success|error', 'file' => string, 'message' => string]
     */
    function CopyDataSiswa(
        string $namaFile,
        string $folderAsal = 'img/siswa',
        string $defaultFile = 'img/default/blanko-foto.png'
    ): array {
        $sourcePath = public_path($folderAsal . '/' . $namaFile);
        $targetDir  = base_path('whatsapp/uploads');
        $targetPath = $targetDir . '/' . $namaFile;

        // cek apakah file ada
        if (!file_exists($sourcePath)) {
            // fallback ke default
            $sourcePath = public_path($defaultFile);
            $targetPath = $targetDir . '/' . basename($defaultFile);

            if (!file_exists($sourcePath)) {
                return [
                    'status'  => 'error',
                    'file'    => basename($defaultFile),
                    'message' => "File default '$defaultFile' tidak ditemukan di public"
                ];
            }

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0775, true);
            }

            copy($sourcePath, $targetPath);

            return [
                'status'  => 'success',
                'file'    => basename($defaultFile),
                'message' => "File '$namaFile' tidak ada, gunakan default '" . basename($defaultFile) . "'"
            ];
        }

        // buat folder tujuan kalau belum ada
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        // copy file asli
        if (!copy($sourcePath, $targetPath)) {
            return [
                'status'  => 'error',
                'file'    => $namaFile,
                'message' => "Gagal menyalin file '$namaFile'"
            ];
        }

        return [
            'status'  => 'success',
            'file'    => $namaFile,
            'message' => "File '$namaFile' berhasil disalin ke whatsapp/uploads/siswa"
        ];
    }
}
if (!function_exists('normalize_image_safe')) {
    function normalize_image_safe($sourcePath)
    {
        try {
            // Coba baca langsung
            $info = @getimagesize($sourcePath);
            if ($info !== false) {
                // PNG normal, gas langsung
                return $sourcePath;
            }

            // Kalau gagal baca (biasanya PNG hasil convert SVG), konversi ke JPG sementara
            $temp = sys_get_temp_dir() . '/' . uniqid('img_') . '.jpg';
            $src = @imagecreatefrompng($sourcePath);
            if (!$src) {
                Log::error("Gagal buka PNG: {$sourcePath}");
                return null;
            }

            $w = imagesx($src);
            $h = imagesy($src);
            $bg = imagecreatetruecolor($w, $h);
            $white = imagecolorallocate($bg, 255, 255, 255);
            imagefill($bg, 0, 0, $white);
            imagecopy($bg, $src, 0, 0, 0, 0, $w, $h);
            imagejpeg($bg, $temp, 90);
            imagedestroy($src);
            imagedestroy($bg);

            Log::info("PNG dikonversi sementara ke JPG: {$sourcePath}");
            return $temp;
        } catch (\Throwable $e) {
            Log::error("Gagal normalisasi gambar: " . $e->getMessage());
            return null;
        }
    }
}

// Gabung png ke pdf
if (!function_exists('gabung_gambar_ke_pdf')) {
    function gabung_gambar_ke_pdf($nis, $folder_list = ['kk', 'ijazah-sd', 'foto', 'karpel', 'ktp-ortu'], $return_stream = false)
    {
        $base_path = public_path('img/siswa'); // 🔥 balik ke jalur lama
        $output_dir = public_path('temp/pdf');
        $pdf = new \setasign\Fpdi\Fpdi('P', 'mm', 'A4');
        $found = false;

        foreach ($folder_list as $folder) {
            $folder_path = "{$base_path}/{$folder}";
            if (!is_dir($folder_path)) {
                Log::warning("❌ Folder tidak ditemukan: {$folder_path}");
                continue;
            }

            // cari semua file yang mengandung NIS di namanya (contoh ayah_230019, ibu_230019, belakang_230019)
            $pattern = "{$folder_path}/*{$nis}*.{png,jpg,jpeg}";
            $files = glob($pattern, GLOB_BRACE);

            if (empty($files)) {
                Log::warning("⚠️ Tidak ada file untuk NIS {$nis} di {$folder}");
                continue;
            }

            // urutan khusus untuk karpel dan ktp-ortu
            if (strtolower($folder) === 'karpel') {
                usort($files, fn($a, $b) => str_contains($a, 'belakang') ? 1 : -1);
                if (count($files) > 1) {
                    $gabung = gabung_gambar_vertikal($files[0], $files[1], "karpel_{$nis}");
                    if ($gabung) $files = [$gabung];
                }
            } elseif (strtolower($folder) === 'ktp-ortu') {
                usort($files, fn($a, $b) => str_contains($a, 'ibu') ? 1 : -1);
                if (count($files) > 0) {
                    $gabung = gabung_gambar_vertikal($files[0], $files[1] ?? null, "ktportu_{$nis}");
                    if ($gabung) $files = [$gabung];
                }
            }

            // render semua gambar hasil
            foreach ($files as $file_path) {
                $info = @getimagesize($file_path);
                if ($info === false) {
                    Log::warning("⚠️ File tidak valid: {$file_path}");
                    continue;
                }

                [$width, $height] = $info;
                $width_mm = $width * 0.264583;
                $height_mm = $height * 0.264583;

                $pdf->AddPage();

                $max_width = 210;
                $max_height = 297;

                // skala beda per folder
                $scaleFactor = match (strtolower($folder)) {
                    'karpel', 'ktp-ortu' => 0.75,
                    'foto'               => 0.6,
                    'nisn'               => 0.75,
                    default              => 1.0,
                };

                $scale = min(($max_width * $scaleFactor) / $width_mm, ($max_height * $scaleFactor) / $height_mm, 1);
                $w = $width_mm * $scale;
                $h = $height_mm * $scale;
                $x = (210 - $w) / 2;
                $y = (297 - $h) / 2;

                $pdf->Image($file_path, $x, $y, $w, $h);
                $found = true;

                Log::info("✅ Tambah ke PDF: {$file_path}");
            }
        }

        if (!$found) {
            Log::error("❌ Tidak ada gambar ditemukan untuk {$nis}");
            return null;
        }

        if (!file_exists($output_dir)) mkdir($output_dir, 0777, true);

        $output_path = "{$output_dir}/{$nis}.pdf";
        $pdf->Output('F', $output_path);

        Log::info("✅ PDF berhasil dibuat: {$output_path}");

        return $return_stream ? response()->file($output_path) : $output_path;
    }
}

// bentuk lain
/*
cara pakai
$folder_str = "kk:ijazah-sd:foto:karpel:ktp-ortu";
$folders = explode(':', $folder_str);
gabung_dokumen_dinamis($nis, $folders);
*/

if (!function_exists('gabung_dokumen_dinamis')) {
    /**
     * Gabungkan berbagai dokumen (gambar, PDF, Word, Excel) berdasarkan NIS & daftar folder
     */
    function gabung_dokumen_dinamis($nis, array $folder_list = [], $return_stream = false)
    {
        $base_path = public_path('img/siswa'); // bisa disesuaikan: 'files/siswa' kalau beda
        $output_dir = public_path('temp/pdf');
        $pdf = new Fpdi('P', 'mm', 'A4');
        $found = false;

        foreach ($folder_list as $folder) {
            $folder_path = "{$base_path}/{$folder}";
            if (!is_dir($folder_path)) {
                Log::warning("⚠️ Folder tidak ditemukan: {$folder_path}");
                continue;
            }

            // Ambil file sesuai NIS
            $pattern = "{$folder_path}/*{$nis}*.{png,jpg,jpeg,pdf,docx,xlsx}";
            $files = glob($pattern, GLOB_BRACE);

            if (empty($files)) {
                Log::warning("⚠️ Tidak ada file untuk NIS {$nis} di folder {$folder}");
                continue;
            }

            // Urutkan biar depan/belakang, ayah/ibu rapi
            sort($files, SORT_NATURAL);

            foreach ($files as $file_path) {
                $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

                try {
                    switch ($ext) {
                        case 'png':
                        case 'jpg':
                        case 'jpeg':
                            [$width, $height] = getimagesize($file_path);
                            $width_mm = $width * 0.264583;
                            $height_mm = $height * 0.264583;

                            $pdf->AddPage();

                            // Skala gambar biar muat A4
                            $max_width = 210;
                            $max_height = 297;
                            $scale = min($max_width / $width_mm, $max_height / $height_mm, 1);

                            // Jika folder foto → perkecil lagi (biar nggak full)
                            if ($folder === 'foto') {
                                $scale *= 0.6;
                            }

                            // Jika karpel → perkecil juga sedikit
                            if ($folder === 'karpel') {
                                $scale *= 0.85;
                            }

                            $w = $width_mm * $scale;
                            $h = $height_mm * $scale;
                            $x = (210 - $w) / 2;
                            $y = (297 - $h) / 2;

                            $pdf->Image($file_path, $x, $y, $w, $h);
                            Log::info("🖼️ Tambah gambar dari {$folder}: {$file_path}");
                            $found = true;
                            break;

                        case 'pdf':
                            $pageCount = $pdf->setSourceFile($file_path);
                            for ($i = 1; $i <= $pageCount; $i++) {
                                $tpl = $pdf->importPage($i);
                                $pdf->AddPage();
                                $pdf->useTemplate($tpl);
                            }
                            Log::info("📄 Gabung PDF dari {$folder}: {$file_path}");
                            $found = true;
                            break;

                        case 'docx':
                            $word = WordIO::load($file_path);
                            $tempPdf = tempnam(sys_get_temp_dir(), 'word_') . '.pdf';
                            $pdfWriter = WordIO::createWriter($word, 'PDF');
                            $pdfWriter->save($tempPdf);

                            $pageCount = $pdf->setSourceFile($tempPdf);
                            for ($i = 1; $i <= $pageCount; $i++) {
                                $tpl = $pdf->importPage($i);
                                $pdf->AddPage();
                                $pdf->useTemplate($tpl);
                            }
                            unlink($tempPdf);
                            Log::info("📝 Word → PDF: {$file_path}");
                            $found = true;
                            break;

                        case 'xlsx':
                            $sheet = SheetIO::load($file_path);
                            $tempPdf = tempnam(sys_get_temp_dir(), 'excel_') . '.pdf';
                            $pdfWriter = new SheetPdf($sheet);
                            $pdfWriter->save($tempPdf);

                            $pageCount = $pdf->setSourceFile($tempPdf);
                            for ($i = 1; $i <= $pageCount; $i++) {
                                $tpl = $pdf->importPage($i);
                                $pdf->AddPage();
                                $pdf->useTemplate($tpl);
                            }
                            unlink($tempPdf);
                            Log::info("📊 Excel → PDF: {$file_path}");
                            $found = true;
                            break;
                    }
                } catch (\Throwable $e) {
                    Log::error("💥 Error pada {$file_path}: " . $e->getMessage());
                }
            }
        }

        if (!$found) {
            Log::warning("❌ Tidak ada file ditemukan untuk NIS {$nis}");
            return null;
        }
        if (!file_exists($output_dir)) mkdir($output_dir, 0777, true);
        $output_path = "{$output_dir}/{$nis}.pdf";
        $pdf->Output('F', $output_path);
        Log::info("✅ PDF berhasil dibuat: {$output_path}");

        return $return_stream ? response()->file($output_path) : $output_path;
    }
}
// Bentuk lain dokumen lengkap siswa
if (!function_exists('dokumen_lengkap_siswa')) {
    function dokumen_lengkap_siswa($nis, $dok, $return_stream = false)
    {
        $base_path   = public_path('img/siswa');
        $output_dir  = public_path('temp/pdf');
        $folder_list = $dok;

        $pdf = new \setasign\Fpdi\Fpdi('P', 'mm', 'A4');
        $found = false;

        // Ambil data siswa dari DB
        $siswa = Detailsiswa::where('nis', $nis)->first();
        if (!$siswa) {
            Log::error("❌ Data siswa dengan NIS {$nis} tidak ditemukan");
            return null;
        }

        // Halaman 1: data siswa
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, "Data Siswa", 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(50, 5, 'NIS', 0, 0);
        $pdf->Cell(0, 5, ': ' . $siswa->nis, 0, 1);
        $pdf->Cell(50, 5, 'NISN', 0, 0);
        $pdf->Cell(0, 5, ': ' . $siswa->nisn, 0, 1);
        $pdf->Cell(50, 5, 'Nama', 0, 0);
        $pdf->Cell(0, 5, ': ' . $siswa->nama_siswa, 0, 1);
        $pdf->Cell(50, 5, 'Kelas', 0, 0);
        $pdf->Cell(0, 5, ': ' . ($siswa->KelasOne->kelas ?? '-'), 0, 1);
        $pdf->Cell(50, 5, 'Catatan', 0, 0);
        $pdf->Cell(0, 5, 'Lampiran dokumen menyusul', 0, 1);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 6, 'Keterangan: Data ini masih bisa berubah.', 0, 1);

        Log::info("✅ Halaman info siswa ditambahkan untuk NIS {$nis}");

        // Proses folder dokumen
        foreach ($folder_list as $folder) {
            $folder_path = "{$base_path}/{$folder}";
            if (!is_dir($folder_path)) {
                Log::warning("❌ Folder tidak ditemukan: {$folder_path}");
                continue;
            }

            // KTP ORTU (AYAH & IBU TERPISAH)
            if (strtolower($folder) === 'ktp-ortu') {
                $files_in_folder = \Illuminate\Support\Facades\File::files($folder_path);
                $ayah_files = [];
                $ibu_files = [];

                foreach ($files_in_folder as $file) {
                    $name = strtolower($file->getFilename());
                    if (str_contains($name, "ayah_{$nis}")) {
                        $ayah_files[] = $file->getPathname();
                    } elseif (str_contains($name, "ibu_{$nis}")) {
                        $ibu_files[] = $file->getPathname();
                    }
                }

                if (empty($ayah_files) && empty($ibu_files)) {
                    Log::warning("⚠️ Tidak ada file KTP Ayah/Ibu untuk NIS {$nis}");
                    continue;
                }

                foreach ($ayah_files as $ayah) {
                    tambah_gambar_ke_pdf($pdf, $ayah, 'ktp-ortu');
                    Log::info("✅ Tambah ke PDF: {$ayah}");
                }

                foreach ($ibu_files as $ibu) {
                    tambah_gambar_ke_pdf($pdf, $ibu, 'ktp-ortu');
                    Log::info("✅ Tambah ke PDF: {$ibu}");
                }

                continue; // skip ke folder berikutnya
            }

            // Folder lain (kk, karpel, foto, dll)
            $files = \Illuminate\Support\Facades\File::glob("{$folder_path}/*{$nis}*.{png,jpg,jpeg}", GLOB_BRACE);

            if (empty($files)) {
                Log::warning("⚠️ Tidak ada file untuk NIS {$nis} di {$folder}");
                continue;
            }

            // Urutan khusus untuk karpel
            if (strtolower($folder) === 'karpel') {
                usort($files, fn($a, $b) => str_contains($a, 'belakang') ? 1 : -1);
                if (count($files) > 1) {
                    $gabung = gabung_gambar_vertikal($files[0], $files[1], "karpel_{$nis}");
                    if ($gabung) $files = [$gabung];
                }
            }

            foreach ($files as $file_path) {
                tambah_gambar_ke_pdf($pdf, $file_path, $folder);
                Log::info("✅ Tambah ke PDF: {$file_path}");
            }
        }

        if (!file_exists($output_dir)) mkdir($output_dir, 0777, true);
        $output_path = "{$output_dir}/{$nis}.pdf";
        $pdf->Output('F', $output_path);
        Log::info("✅ PDF berhasil dibuat: {$output_path}");

        return $return_stream ? response()->file($output_path) : $output_path;
    }
}

// 🔧 Helper kecil biar rapi
if (!function_exists('tambah_gambar_ke_pdf')) {
    function tambah_gambar_ke_pdf($pdf, $file_path, $folder)
    {
        $info = @getimagesize($file_path);
        if ($info === false) {
            Log::warning("⚠️ File tidak valid: {$file_path}");
            return;
        }

        [$width, $height] = $info;
        $width_mm = $width * 0.264583;
        $height_mm = $height * 0.264583;

        $pdf->AddPage();

        $max_width = 210;
        $max_height = 297;

        $scaleFactor = match (strtolower($folder)) {
            'karpel'     => 0.75,
            'ktp-ortu'   => 1.5, // diperbesar
            'foto'       => 0.6,
            'nisn'       => 0.75,
            'kk'         => 0.95,
            default      => 1.0,
        };

        // Hitung skala, tapi jangan biarkan melebihi halaman
        $scale = min(($max_width * $scaleFactor) / $width_mm, ($max_height * $scaleFactor) / $height_mm, 1);

        $w = $width_mm * $scale;
        $h = $height_mm * $scale;

        // Geser posisi biar gambar tetap center dan tidak keluar batas
        $x = (210 - $w) / 2;
        $y = max((297 - $h) / 2, 0); // pastikan tidak negatif (tidak keluar ke atas)

        // Jika gambar lebih tinggi dari halaman, kecilkan sedikit otomatis
        if ($h > 297) {
            $ratio = 297 / $h;
            $w *= $ratio;
            $h = 297;
            $x = (210 - $w) / 2;
            $y = 0;
        }

        $pdf->Image($file_path, $x, $y, $w, $h);
    }
}



if (!function_exists('gabung_gambar_vertikal')) {
    function gabung_gambar_vertikal($atasPath, $bawahPath = null, $prefix = 'gabung')
    {
        if (!$atasPath || !file_exists($atasPath)) return null;

        $img1 = @imagecreatefromstring(file_get_contents($atasPath));
        $img2 = $bawahPath && file_exists($bawahPath)
            ? @imagecreatefromstring(file_get_contents($bawahPath))
            : null;

        if (!$img1) return null;

        $w = $img2 ? max(imagesx($img1), imagesx($img2)) : imagesx($img1);
        $h = imagesy($img1) + ($img2 ? imagesy($img2) : 0);

        $gabung = imagecreatetruecolor($w, $h);
        $putih = imagecolorallocate($gabung, 255, 255, 255);
        imagefill($gabung, 0, 0, $putih);
        imagecopy($gabung, $img1, 0, 0, 0, 0, imagesx($img1), imagesy($img1));
        if ($img2) imagecopy($gabung, $img2, 0, imagesy($img1), 0, 0, imagesx($img2), imagesy($img2));

        $temp_path = sys_get_temp_dir() . "/{$prefix}_" . uniqid() . ".png";
        imagepng($gabung, $temp_path);

        imagedestroy($img1);
        if ($img2) imagedestroy($img2);
        imagedestroy($gabung);

        return $temp_path;
    }
}
