<?php


use Carbon\Carbon;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;

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
