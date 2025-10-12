<?php

use Carbon\Carbon;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

// Mengambil data guru dan dijadikan format ul>li
if (!function_exists('ambilNamaGuru')) {
    function ambilNamaGuru($guruIds)
    {
        // Kalau bentuknya string JSON, decode dulu
        if (is_string($guruIds)) {
            $guruIds = json_decode($guruIds, true); // hasilnya array
        }

        // Kalau hasil decode bukan array (atau null), kasih fallback
        if (!is_array($guruIds) || count($guruIds) === 0) {
            return "<ul><li><em>Tidak ada guru terdaftar</em></li></ul>";
        }

        $namaGurus = Detailguru::whereIn('id', $guruIds)->pluck('nama_guru');

        return "<ul>" . $namaGurus->map(fn($nama) => "<li>{$nama}</li>")->implode('') . "</ul>";
    }
}

if (!function_exists('guruId')) {
    function guruId()
    {
        return Auth::user()->detailguru_id;
    }
}
if (!function_exists('cekGuruInJson')) {
    function cekGuruDalamJson($jsonGuruIds, $detailguruId)
    {
        // Decode JSON ke array
        $guruIds = json_decode($jsonGuruIds, true);

        // Kalau decode gagal atau bukan array, langsung return false
        if (!is_array($guruIds)) {
            return false;
        }

        // Cek apakah $detailguruId ada di array
        return in_array($detailguruId, $guruIds);
    }
}
if (!function_exists('CekKodeGuru')) {
    function CekKodeGuru($kode, $pecahNo)
    {
        // harusnya dicek berdasarkan no bukan kode jika terdaftar sebagai guru oke, jika tidak berhenti
        $sessions = config('whatsappSession.IdWaUtama');
        $message =
            "================================\n" .
            "📌 *INFORMASI*\n" .
            "================================\n\n" .
            "Pesan ini hanya bisa diakses paket *Premium*";
        // Ambil semua kode guru dari database (misalnya ['JA', 'RA', 'RN'])
        $kodeGuruList = Detailguru::pluck('kode_guru')->toArray();

        // Cek apakah kode yang diberikan ada dalam daftar kode guru
        if (!in_array($kode, $kodeGuruList)) {
            \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $pecahNo, $message);; // atau return false;
            exit; // << STOP TOTAL, tidak lanjut ke bawah
        }

        // Lolos
        return true;
    }
}
if (!function_exists('CekGuru')) {
    function CekGuru($pecahNo)
    {
        // Nama sesi WA (misal untuk multi-session WA)
        $sessions = config('whatsappSession.IdWaUtama');
        $message =
            "================================\n" .
            "📌 *INFORMASI*\n" .
            "================================\n\n" .
            "Pesan ini hanya bisa diakses oleh akun guru yang terdaftar sebagai guru.";

        // Ambil semua no_hp guru dari database
        $noGuruList = Detailguru::pluck('no_hp')->toArray();
        \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $pecahNo,  $noGuruList);
        // Cek apakah no HP terdaftar
        if (!in_array($pecahNo, $noGuruList)) {
            \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $pecahNo, $message);
            exit; // Stop total akses jika tidak terdaftar
        }

        // Kalau terdaftar, lanjut
        return true;
    }
}
if (!function_exists('umurGuru')) {
    /**
     * Menghitung umur dari tanggal lahir.
     *
     * @param string|Carbon $tanggal_lahir
     * @return int|null
     */
    function umurGuru($tanggal_lahir)
    {
        if (!$tanggal_lahir) return null;

        return Carbon::parse($tanggal_lahir)->age;
    }
}
if (!function_exists('DataGuru')) {
    /**
     * Menghitung umur dari tanggal lahir.
     *
     * @param string|Carbon $tanggal_lahir
     * @return int|null
     */
    function DataGuru($kode)
    {
        $Guru = Detailguru::where('kode_guru', $kode)->first();
        if (!$Guru->gelar) {
            $nama_guru = $Guru->nama_guru ?? '-';
        } else {
            $nama_guru = $Guru->nama_guru . ',' . $Guru->gelar;
        }

        $data = [
            'nama_guru' => $nama_guru,
            'nip_guru' => $Guru->nip_guru ?? '-',
        ];
        return $data;
    }
}
if (!function_exists('DataWaka')) {
    /**
     * Menghitung umur dari tanggal lahir.
     *
     * @param string|Carbon $tanggal_lahir
     * @return int|null
     */
    function DataWaka($kode)
    {
        $Guru = Detailguru::where('kode_guru', $kode)->first();
        if (!$Guru->gelar) {
            $nama_guru = $Guru->nama_guru ?? '-';
        } else {
            $nama_guru = $Guru->nama_guru . ',' . $Guru->gelar;
        }

        $data = [
            'nama_waka' => $nama_guru ?? '-',
            'nip_waka' => $Guru->nip_guru ?? '-',
        ];
        return $data;
    }
}
if (!function_exists('getGurus')) {
    /**
     * Ambil data guru dengan opsi exclude dan limit
     *
     * @param array $excludeIds  Daftar ID guru yang ingin dikecualikan
     * @param int|null $limit    Jumlah maksimal guru yang diambil, null = semua
     * @return \Illuminate\Database\Eloquent\Collection
     *
     * Cara penggunaan:
     * $guruSemua = getGurusAktif();               // Semua guru kecuali default 1,2,3
     * $guruLimit5 = getGurusAktif([], 5);        // 5 guru pertama
     * $guruExclude = getGurusAktif([4,5,6]);     // Semua kecuali ID 4,5,6
     */
    function getGurus(array $excludeIds = [1, 2, 3], ?int $limit = null)
    {
        $query = Detailguru::query();

        if (!empty($excludeIds)) {
            $query->whereNotIn('id', $excludeIds);
        }

        if ($limit !== null) {
            $query->limit($limit); // diterapkan sebelum get(), lebih efisien
        }

        return $query->get();
    }
}

if (!function_exists('CekGuru')) {
    function CekGuru($kodeGuru): bool
    {
        if (!$kodeGuru) {
            return false;
        }
        return Detailguru::where('kode_guru', $kodeGuru)->exists();
    }
}
// Generate Kode Guru
if (!function_exists('generate_kode_guru')) {
    function generate_kode_guru($nama_guru)
    {
        // Array statis: menampung semua kode yang sudah dipakai
        static $kode_terpakai = [];

        // 1️⃣ Ambil semua huruf besar dari nama
        preg_match_all('/[A-Z]/', $nama_guru, $matches);
        $kode = implode('', $matches[0]);

        // 2️⃣ Kalau gak ada huruf besar, ambil huruf awal tiap kata (case-insensitive)
        if ($kode === '') {
            preg_match_all('/\b[a-z]/i', $nama_guru, $matches);
            $kode = strtoupper(implode('', $matches[0]));
        }

        // 3️⃣ Pastikan kode unik
        $kode_asli = $kode;
        $counter = 1;
        while (in_array($kode, $kode_terpakai)) {
            $kode = $kode_asli . $counter; // tambah angka berurutan (bisa diganti random kalau mau)
            $counter++;
        }

        // 4️⃣ Simpan ke daftar kode terpakai
        $kode_terpakai[] = $kode;

        // 5️⃣ Return kode unik
        return $kode;
    }
}
