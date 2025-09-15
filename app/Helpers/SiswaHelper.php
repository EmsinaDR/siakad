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
