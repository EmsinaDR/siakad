<?php

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

// Cek dulu, apakah fungsi 'tgl' sudah didefinisikan sebelumnya atau belum
if (!function_exists('tgl')) {

    // Kalau belum ada, kita buat fungsi 'tgl' yang menerima dua parameter:
    // $tanggal: tanggal input yang mau diformat (string atau DateTime)
    // $format: format output tanggal, default 'Y-m-d' (tahun-bulan-tanggal)
    function tgl($tanggal, $format = 'Y-m-d')
    {

        // Gunakan Carbon untuk membuat objek tanggal dari input $tanggal
        // lalu format tanggal tersebut sesuai format yang diminta
        // translatedFormat mengembalikan tanggal dengan nama bulan/hari yang sudah diterjemahkan ke bahasa lokal (misal bahasa Indonesia)
        // tgl($data->tanggal, 'l, Y m d');
        return Carbon::create($tanggal)->translatedFormat($format);
    }
}

// Cek dulu, apakah fungsi 'strpad' sudah ada atau belum supaya gak error fungsi ganda
if (!function_exists('strpad')) {
    /**
     * Fungsi untuk menambahkan padding nol di depan angka supaya panjang string sesuai kebutuhan.
     *
     * @param int|string $angka Angka asli yang mau dipadding
     * @param int $length Panjang total string hasil padding, default 3
     * @return string Angka yang sudah dipadding nol di depan
     */
    function strpad($angka, $length = 3)
    {
        // Gunakan fungsi bawaan PHP str_pad untuk menambahkan karakter '0' di kiri (STR_PAD_LEFT)
        return str_pad($angka, $length, '0', STR_PAD_LEFT);
    }
}
if (!function_exists('umur')) {
    /**
     * Menghitung umur dari tanggal lahir.
     *
     * @param string|Carbon $tanggal_lahir
     * @return int|null
     */
    function umur($tanggal_lahir)
    {
        if (!$tanggal_lahir) return null;

        return Carbon::parse($tanggal_lahir)->age;
    }
}

// vai get
if (!function_exists('cleanPesanWAGet')) {
    function cleanPesanWAGet($html)
    {
        // Ubah <p> jadi new line biar rapi
        $text = preg_replace('/<\/?p[^>]*>/', "\n", $html);

        // Ubah <strong> jadi bold WA pakai *
        $text = preg_replace('/<strong>(.*?)<\/strong>/i', '*$1*', $text);

        // Hapus tag HTML lain
        $text = strip_tags($text);

        // Trim, replace multi-newline jadi 1 newline
        $text = preg_replace('/\n{2,}/', "\n", $text);

        // URL encode
        return urlencode(trim($text));
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Helper generate tanggal sesuai interval :
    |--------------------------------------------------------------------------
    |

    | Tujuan :
    | - Pembuatan array tanggal dengan generator sesuai ketentuan
    | - Membuat tanggal dari tanggal mulai sampai akhir tetapi mengambil hari tertentu saja
    |
    |
    */
// Proses Coding

if (!function_exists('generateTanggalJamByHari')) {
    /**
     * Membuat array tanggal + jam berdasarkan hari tertentu dalam rentang tanggal.
     *
     * @param string $tanggalMulai Format 'Y-m-d', misal: '2025-07-25'
     * @param string $tanggalAkhir Format 'Y-m-d', misal: '2025-10-25'
     * @param int $hariTarget Gunakan konstanta Carbon::MONDAY, Carbon::TUESDAY, dll.
     * @param string $jamTetap Format 'H:i:s', misal: '08:00:00'
     * @param int|null $batasJumlah (Opsional) Ambil hanya sebanyak jumlah ini, jika diberikan
     * int $batasJumlah = null = data
     * Carbon::SUNDAY    = 0 // Minggu
     * Carbon::MONDAY    = 1 // Senin
     * Carbon::TUESDAY   = 2 // Selasa
     * Carbon::WEDNESDAY = 3 // Rabu
     * Carbon::THURSDAY  = 4 // Kamis
     * Carbon::FRIDAY    = 5 // Jum'at
     * Carbon::SATURDAY  = 6 // Sabtu
     * Contoh penggunaan : generateTanggalJamByHari('2025-08-01', '2025-09-30', 1, '08:00:00', 3); // Akan ambil 3 Senin pertama saja.
     * Contoh penggunaan : $hasil = generateTanggalJamByHari('2025-08-01', '2025-08-31', [0, 1], '08:00:00'); // Minggu dan Senin
     * Contoh penggunaan : generateTanggalJamByHari('2025-08-01', '2025-09-30', 1) // Ambil semua tanggal dan yang dipilih hari senin, jam default
     * @return array Array berisi tanggal lengkap (Y-m-d H:i:s) pada hari tertentu
     */
    function generateTanggalJamByHari(
        string $tanggalMulai,
        string $tanggalAkhir,
        int|array $hariTarget,
        string $jamTetap = '08:00:00',
        int $batasJumlah = null
    ): array {
        // Konversi tanggal string ke objek Carbon
        $startDate = Carbon::createFromFormat('Y-m-d', $tanggalMulai);
        $endDate   = Carbon::createFromFormat('Y-m-d', $tanggalAkhir);

        // Buat periode tanggal dari tanggalMulai sampai tanggalAkhir
        $period = CarbonPeriod::create($startDate, $endDate);

        // Array penampung hasil akhir
        $result = [];

        // Jika hariTarget bukan array, jadikan array agar konsisten
        $hariTarget = is_array($hariTarget) ? $hariTarget : [$hariTarget];

        // Loop tiap tanggal dalam periode
        foreach ($period as $tanggal) {
            // Cek apakah hari dari tanggal saat ini termasuk dalam hariTarget
            if (in_array($tanggal->dayOfWeek, $hariTarget)) {
                // Salin tanggal, set jam tetap, lalu simpan dalam format datetime string
                $result[] = $tanggal->copy()->setTimeFromTimeString($jamTetap)->toDateTimeString();
            }
        }

        // Jika batas jumlah ditentukan, potong array hasil
        return $batasJumlah ? array_slice($result, 0, $batasJumlah) : $result;
    }
}

function tglall($tanggal, $preset = 'default')
{
    if (!$tanggal) return '-';

    $format = match ($preset) {
        'default' => 'Y-m-d',
        'indo'    => 'd F Y',
        'long'    => 'l, d F Y',
        'short'   => 'd/m/Y',
        default   => $preset,
    };

    $formatted = Carbon::create($tanggal)->translatedFormat($format);

    // Ubah agar huruf pertama tiap kata kapital (khususnya untuk bulan dan hari)
    return ucwords($formatted);
}
if (! function_exists('tanggal_interval')) {
    /**
     * Ambil daftar tanggal dalam interval dengan pengecualian hari.
     *
     * @param  string  $start   Tanggal awal (Y-m-d atau d-m-Y)
     * @param  string  $end     Tanggal akhir (Y-m-d atau d-m-Y)
     * @param  array   $excludeDays  Hari yang dikecualikan (0=Min ... 6=Sab)
     * @param  string  $format  Format output tanggal (default Y-m-d)
     * 0 = Minggu
     * 1 = Senin
     * 2 = Selasa
     * 3 = Rabu
     * 4 = Kamis
     * 5 = Jumat
     * 6 = Sabtu
     * Contoh : tanggal_interval('2-juli-2025','2-september-2025',[0,6])
     * Hasil :
     * Array
     * (
     *     [0] => 2025-07-02
     *     [1] => 2025-07-03
     *     [2] => 2025-07-04
     *     [3] => 2025-07-07
     *     ...
     *     [n] => 2025-09-02
     * )
     * @return array
     *
     */
    function tanggal_interval(string $start, string $end, array $excludeDays = [], string $format = 'Y-m-d'): array
    {
        $startDate = date_create(date('Y-m-d', strtotime($start)));
        $endDate   = date_create(date('Y-m-d', strtotime($end)));

        $dates = [];

        while ($startDate <= $endDate) {
            $dayNum = (int) $startDate->format('w'); // 0=Min ... 6=Sab
            if (!in_array($dayNum, $excludeDays)) {
                $dates[] = $startDate->format($format);
            }
            $startDate->modify('+1 day');
        }

        return $dates;
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Data dan Time :
    |--------------------------------------------------------------------------
    |
    |
    | Tujuan :
    | - Menggabungkan tanggal dan waktu
    | - xxxxxxxxxxx
    | - xxxxxxxxxxx
    |
    |
    | Penggunaan :
    | - $jadwal = TglWkatu('2025-07-27', '08:30');
    |
    */
// Proses Coding
if (!function_exists('TglWkatu')) {
    function TglWkatu($tanggal, $waktu)
    {
        try {
            $scheduled_at = Carbon::createFromFormat('Y-m-d H:i', "$tanggal $waktu");
            return $scheduled_at->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null; // atau bisa lempar error/log
        }
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Ckear Data No HP :
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
if (!function_exists('format_no_hp')) {
    function format_no_hp(string $nomor): string
    {
        // Hilangkan semua karakter kecuali angka dan plus
        $nomor = preg_replace('/[^0-9\+]/', '', $nomor);

        // Jika diawali dengan '00' ubah jadi '+'
        if (substr($nomor, 0, 2) === '00') {
            $nomor = '+' . substr($nomor, 2);
        }

        // Hilangkan tanda plus
        $nomor = ltrim($nomor, '+');

        // Jika diawali 0, ganti jadi 62
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        }

        return $nomor;
    }
}

/*
    |--------------------------------------------------------------------------
    | 📌 Format Data Tanggal :
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
if (!function_exists('format_tanggal_lahir')) {
    function format_tanggal_lahir(string $tanggal): ?string
    {
        // Bersihkan karakter aneh
        $tanggal = trim($tanggal, "'\" ");

        // Format sudah benar?
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            return $tanggal; // sudah format yyyy-mm-dd
        }

        // Deteksi format dd/mm/yyyy
        $parts = explode('/', $tanggal);
        if (count($parts) === 3) {
            [$dd, $mm, $yyyy] = $parts;

            if (checkdate((int)$mm, (int)$dd, (int)$yyyy)) {
                return sprintf('%04d-%02d-%02d', $yyyy, $mm, $dd);
            }
        }

        return null;
    }
}
if (! function_exists('isEndOfMonthMinusOneSunday')) {
    /**
     * Mengecek apakah hari ini adalah "H-1" dari akhir bulan, ketika akhir bulan jatuh pada hari Minggu.
     *
     * Logika:
     * 1. Ambil tanggal akhir bulan sekarang (misalnya 31 Agustus).
     * 2. Cek apakah tanggal akhir bulan jatuh pada hari Minggu.
     * 3. Jika iya → ambil sehari sebelumnya (misalnya 30 Agustus).
     * 4. Bandingkan dengan tanggal hari ini:
     *      - Kalau sama → return true.
     *      - Kalau beda → return false.
     *
     * Contoh:
     * - Hari ini 30 September 2023
     * - 30 September = Sabtu
     * - 1 Oktober = Minggu (akhir bulan)
     * → return true
     *
     * @return bool
     * if (isEndOfMonthMinusOneSunday()) {
     *   return "Hari ini H-1 akhir bulan Minggu → Action jalan!";
     *}
     *
     *
     */

    function isEndOfMonthMinusOneSunday(): bool
    {
        $today = Carbon::today();
        $endOfMonth = Carbon::now()->endOfMonth();

        if ($endOfMonth->isSunday()) {
            $checkDate = $endOfMonth->copy()->subDay();
            return $today->isSameDay($checkDate);
        }

        return false;
    }
}
if (! function_exists('CekAkhirBulan')) {
    /**
     * Mengecek apakah hari ini adalah tanggal akhir bulan.
     *
     * Logika:
     * 1. Ambil tanggal hari ini.
     * 2. Ambil tanggal akhir bulan (endOfMonth).
     * 3. Bandingkan → kalau sama return true.
     *
     * Contoh:
     * - Hari ini 31 Januari → true
     * - Hari ini 28 Februari (tahun biasa) → true
     * - Hari ini 29 Februari (tahun kabisat) → true
     * - Hari ini 30 April → true
     *
     * @return bool
     */
    function CekAkhirBulan(): bool
    {
        $today = Carbon::today();
        $endOfMonth = Carbon::now()->endOfMonth();

        return $today->isSameDay($endOfMonth);
    }
}
if (! function_exists('TglAwalBulan')) {
    /**
     * Mengecek apakah hari ini adalah tanggal awal bulan (tgl 1).
     *
     * Logika:
     * 1. Ambil tanggal hari ini.
     * 2. Ambil tanggal awal bulan (startOfMonth).
     * 3. Bandingkan → kalau sama return true.
     *
     * Contoh:
     * - Hari ini 1 Januari → true
     * - Hari ini 1 Februari → true
     * - Hari ini 15 Agustus → false
     *
     *  if (isTodayStartOfMonth()) {
     *    return "Hari ini awal bulan 🎉";
     *}
     * @return bool
     */
    function TglAwalBulan(): bool
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        return $today->isSameDay($startOfMonth);
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Kecilkan Nama yang ada titlenya :
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
if (!function_exists('ucwords_nama_dengan_gelar')) {
    function ucwords_nama_dengan_gelar(string $namaLengkap): string
    {
        $parts = explode(',', $namaLengkap, 2); // Pisahkan berdasarkan koma pertama
        $nama = isset($parts[0]) ? ucwords(strtolower(trim($parts[0]))) : '';
        $gelar = isset($parts[1]) ? ',' . trim($parts[1]) : '';

        return $nama . $gelar;
    }
}
if (!function_exists('singkatkan_nama')) {
    function singkatkan_nama($namaLengkap)
    {
        // Pisahkan antara nama dan gelar (asumsi gelar dimulai setelah koma atau kapital titik-titik)
        // Contoh: "Ameliya Nur Hikmah A.md.ds" atau "Ameliya Nur Hikmah, S.Pd"

        // Pisahkan gelar dari nama utama
        $namaGelar = preg_split('/[,]/', $namaLengkap, 2); // misah pakai koma
        $namaUtama = trim($namaGelar[0]);
        $gelar = isset($namaGelar[1]) ? trim($namaGelar[1]) : '';

        // Atau kalau nggak ada koma, cari potensi gelar (kata berisi titik)
        if (!$gelar && preg_match_all('/\b[\w]+\.[\w\.]*/i', $namaLengkap, $matches)) {
            $gelar = implode(' ', $matches[0]);
            // Hapus gelar dari nama utama
            $namaUtama = trim(str_replace($gelar, '', $namaLengkap));
        }

        // Pisah nama utama jadi array
        $parts = explode(' ', $namaUtama);
        $jumlah = count($parts);

        if ($jumlah > 2) {
            // Ambil 2 pertama, dan inisial dari sisanya
            $namaPendek = $parts[0] . ' ' . $parts[1];

            for ($i = 2; $i < $jumlah; $i++) {
                $namaPendek .= ' ' . strtoupper(substr($parts[$i], 0, 1)) . '.';
            }
        } else {
            $namaPendek = $namaUtama;
        }

        return trim($namaPendek . ($gelar ? ' ' . $gelar : ''));
    }
}

/*
    |--------------------------------------------------------------------------
    | 📌 IsDay :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - Mengecek hari ini hari apa
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - Mengecek hari ini hari apa jika iya akan proses eksekusi
    |
    |
    | Penggunaan :
    | - xxxxxxxxxxx
    |
    | is_day('sabtu');               // true kalau hari ini Sabtu
    | is_day('saturday');            // sama, tapi pakai Inggris
    | is_day('Rabu', '2025-08-06');  // true
    | is_day('jumat', '2025-08-08'); // true
    | is_day('jum\'at', '2025-08-08'); // juga true

    if (is_day('minggu')) {
        echo "Libur, Bro!";
    }
    */
// Proses Coding
if (!function_exists('is_day')) {
    /**
     * Cek apakah hari dari tanggal (atau hari ini) adalah hari tertentu
     *
     * @param string $hari      Nama hari (dalam Inggris atau Indonesia)
     * @param string|null $tanggal Tanggal (optional), default hari ini
     * @return bool
     */
    function is_day(string $hari, string $tanggal = null): bool
    {
        // Pemetaan nama hari ke format Carbon
        $mapHari = [
            'minggu'    => 'sunday',
            'senin'     => 'monday',
            'selasa'    => 'tuesday',
            'rabu'      => 'wednesday',
            'kamis'     => 'thursday',
            'jumat'     => 'friday',
            'jum\'at'   => 'friday',
            'sabtu'     => 'saturday',

            'sunday'    => 'sunday',
            'monday'    => 'monday',
            'tuesday'   => 'tuesday',
            'wednesday' => 'wednesday',
            'thursday'  => 'thursday',
            'friday'    => 'friday',
            'saturday'  => 'saturday',
        ];

        $hari = strtolower(trim($hari));
        $cariHari = $mapHari[$hari] ?? null;

        if (!$cariHari) return false;

        $tanggal = $tanggal ? Carbon::parse($tanggal) : Carbon::now();
        return strtolower($tanggal->format('l')) === $cariHari;
    }
}

function bulanRomawi($bulan)
{
    $romawi = [
        'I',
        'II',
        'III',
        'IV',
        'V',
        'VI',
        'VII',
        'VIII',
        'IX',
        'X',
        'XI',
        'XII'
    ];

    // Ubah string bulan ke integer (biar aman)
    $index = intval($bulan) - 1;

    return $romawi[$index] ?? '';
}


if (! function_exists('strpad')) {
    /**
     * Pad a string to a certain length with another string.
     *
     * @param  string  $string   String asal
     * @param  int     $length   Panjang target string
     * @param  string  $padStr   Karakter untuk padding
     * @param  string  $type     left|right|both
     * @return string
     * strpad('7', 3, '0', 'left');   // output: 007
     * strpad('Bro', 10, '-', 'right'); // output: Bro-------
     * strpad('Guru', 12, '*', 'both'); // output: ****Guru****

     */
    function strpad(string $string, int $length, string $padStr = ' ', string $type = 'right'): string
    {
        $string = (string) $string;

        if ($type === 'left') {
            return str_pad($string, $length, $padStr, STR_PAD_LEFT);
        }

        if ($type === 'both') {
            return str_pad($string, $length, $padStr, STR_PAD_BOTH);
        }

        // default: right
        return str_pad($string, $length, $padStr, STR_PAD_RIGHT);
    }
}

// Generate Code Enscription
/*
    $pesan = "Guru kece bro!";
    $enc   = encrypt_str($pesan);
    $dec   = decrypt_str($enc);
*/
if (!function_exists('encrypt_strhas')) {
    function encrypt_strhas(string $data, string $secretKey = 'rahasiaBro'): string
    {
        $method = 'AES-256-CBC';
        $key = hash('sha256', $secretKey, true);
        $iv = substr(hash('sha256', $secretKey . 'iv'), 0, 16);
        return base64_encode(openssl_encrypt($data, $method, $key, 0, $iv));
    }
}

if (!function_exists('decrypt_strhas')) {
    function decrypt_strhas(string $encrypted, string $secretKey = 'rahasiaBro'): string
    {
        $method = 'AES-256-CBC';
        $key = hash('sha256', $secretKey, true);
        $iv = substr(hash('sha256', $secretKey . 'iv'), 0, 16);
        return openssl_decrypt(base64_decode($encrypted), $method, $key, 0, $iv);
    }
}
// enscript
/*
// ========== Crypt ==========
    $enc = encrypt_str('Guru Kece');
    echo $enc; // hasil terenkripsi acak

    echo decrypt_str($enc);
    // Output: Guru Kece

    var_dump(is_encrypted($enc)); // true
    var_dump(is_encrypted('BukanEnkripsi')); // false


    // ========== Hash ==========
    $hashed = hash_str('password123');
    echo $hashed;
    // hasil hash acak (tiap kali beda)

    var_dump(check_hash('password123', $hashed)); // true
    var_dump(check_hash('salah', $hashed));       // false

*/
if (!function_exists('encrypt_str')) {
    /**
     * Enkripsi string (bisa didekripsi kembali)
     */
    function encrypt_str($string)
    {
        return Crypt::encryptString($string);
    }
}

if (!function_exists('decrypt_str')) {
    /**
     * Dekripsi string terenkripsi
     */
    function decrypt_str($string)
    {
        return Crypt::decryptString($string);
    }
}

if (!function_exists('is_encrypted')) {
    /**
     * Cek apakah string valid terenkripsi oleh Crypt
     * (return true jika bisa didekripsi, false jika gagal)
     */
    function is_encrypted($string): bool
    {
        try {
            Crypt::decryptString($string);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (!function_exists('check_decrypt')) {
    /**
     * Cek apakah hasil decrypt string sama dengan nilai tertentu
     */
    function check_decrypt($encrypted, $expected): bool
    {
        try {
            $decrypted = Crypt::decryptString($encrypted);
            return $decrypted === $expected;
        } catch (\Exception $e) {
            return false;
        }
    }
}

// 🔑 Password Hash (sekali jalan, tidak bisa didekripsi)
if (!function_exists('hash_str')) {
    /**
     * Hash string (biasanya untuk password)
     */
    function hash_str($string)
    {
        return Hash::make($string);
    }
}

if (!function_exists('check_hash')) {
    /**
     * Verifikasi apakah plain string cocok dengan hash
     */
    function check_hash($plain, $hashed): bool
    {
        return Hash::check($plain, $hashed);
    }
}

// Array
// single
if (!function_exists('arr_has')) {
    function arr_has($value, array $array, $strict = false): bool
    {
        return in_array($value, $array, $strict);
    }
}
if (!function_exists('arr_has_any')) {
    /**
     * arr_has_any
     * -------------------------------------------------
     * Mengecek apakah minimal salah satu nilai ($needles)
     * ada di dalam array target ($haystack).
     *
     * @param array $needles   Nilai-nilai yang mau dicari (contoh: ['admin','editor'])
     * @param array $haystack  Array tempat nyari (contoh: ['admin','guru','siswa'])
     * @param bool  $strict    Jika true, cek tipe data juga (mirip in_array strict)
     * @return bool            True kalau ada minimal satu nilai ditemukan
     */
    /*
        $roles = ['admin','guru','siswa'];

        // Cek apakah salah satu ada (ANY)
        if (arr_has_any(['editor','guru'], $roles)) {
            echo "✅ Ada minimal 1 yang cocok\n";
            // true → karena 'guru' ada di $roles
        }

        // Cek apakah semua ada (ALL)
        if (arr_has_all(['admin','guru'], $roles)) {
            echo "✅ Semua cocok\n";
            // true → karena 'admin' & 'guru' ada semua
        }

        if (!arr_has_all(['admin','editor'], $roles)) {
            echo "❌ Tidak semua ada\n";
            // false → karena 'editor' tidak ada
        }
    */
    function arr_has_any(array $needles, array $haystack, bool $strict = false): bool
    {
        foreach ($needles as $needle) {
            if (in_array($needle, $haystack, $strict)) {
                return true; // stop langsung, cukup satu yang cocok
            }
        }
        return false; // tidak ada satupun yang cocok
    }
}

if (!function_exists('arr_has_all')) {
    /**
     * arr_has_all
     * -------------------------------------------------
     * Mengecek apakah SEMUA nilai ($needles)
     * ada di dalam array target ($haystack).
     *
     * @param array $needles   Nilai-nilai yang mau dicari (contoh: ['admin','guru'])
     * @param array $haystack  Array tempat nyari (contoh: ['admin','guru','siswa'])
     * @param bool  $strict    Jika true, cek tipe data juga (mirip in_array strict)
     * @return bool            True kalau semua nilai ditemukan
     */
    function arr_has_all(array $needles, array $haystack, bool $strict = false): bool
    {
        foreach ($needles as $needle) {
            if (!in_array($needle, $haystack, $strict)) {
                return false; // langsung stop kalau ada yang tidak ketemu
            }
        }
        return true; // semua nilai ketemu
    }
}
// Pregmatch
/*

        $text = "Kode: A123, B456, dan C789.";

        // Cek apakah ada angka
        if (preg_has('/[0-9]+/', $text)) {
            echo "✅ Ada angka\n";
        }

        // Ambil angka pertama
        echo preg_get('/[0-9]+/', $text);
        // Output: 123

        // Ambil semua angka
        print_r(preg_all('/[0-9]+/', $text));
        // Output: Array ( [0] => 123 [1] => 456 [2] => 789 )

        preg_has() → boolean (ada kecocokan atau tidak)
        preg_get() → hasil pertama
        preg_all() → semua hasil

        $kode = "2025001";
        // Apakah diawali 2025?
        if (starts_with($kode, '2025')) {
            echo "✅ Diawali dengan 2025\n";
        }

        // Apakah diakhiri 001?
        if (ends_with($kode, '001')) {
            echo "✅ Diakhiri dengan 001\n";
        }

        // Apakah mengandung '25' di mana saja?
        if (contains($kode, '25')) {
            echo "✅ Mengandung 25\n";
        }


    */
if (!function_exists('preg_has')) {
    /**
     * preg_has
     * -------------------------------------------------
     * Mengecek apakah sebuah string cocok dengan pola regex.
     *
     * @param string $pattern  Pola regex (contoh: '/^[0-9]+$/')
     * @param string $subject  String yang dicek
     * @return bool            True kalau ada kecocokan, false kalau tidak
     */
    function preg_has(string $pattern, string $subject): bool
    {
        return preg_match($pattern, $subject) === 1;
    }
}

if (!function_exists('preg_get')) {
    /**
     * preg_get
     * -------------------------------------------------
     * Mengambil hasil match pertama dari regex.
     *
     * @param string $pattern  Pola regex
     * @param string $subject  String target
     * @return string|null     Hasil pertama, atau null kalau tidak cocok
     */
    function preg_get(string $pattern, string $subject): ?string
    {
        return preg_match($pattern, $subject, $matches) ? $matches[0] : null;
    }
}

if (!function_exists('preg_all')) {
    /**
     * preg_all
     * -------------------------------------------------
     * Mengambil semua hasil match dari regex.
     *
     * @param string $pattern  Pola regex
     * @param string $subject  String target
     * @return array           Array hasil semua match
     */
    function preg_all(string $pattern, string $subject): array
    {
        preg_match_all($pattern, $subject, $matches);
        return $matches[0] ?? [];
    }
}
if (!function_exists('starts_with')) {
    /**
     * Cek apakah string diawali dengan teks tertentu
     */
    function starts_with(string $haystack, string $needle): bool
    {
        return preg_match('/^' . preg_quote($needle, '/') . '/', $haystack) === 1;
    }
}

if (!function_exists('ends_with')) {
    /**
     * Cek apakah string diakhiri dengan teks tertentu
     */
    function ends_with(string $haystack, string $needle): bool
    {
        return preg_match('/' . preg_quote($needle, '/') . '$/', $haystack) === 1;
    }
}

if (!function_exists('contains')) {
    /**
     * Cek apakah string mengandung teks tertentu
     */
    function contains(string $haystack, string $needle): bool
    {
        return preg_match('/' . preg_quote($needle, '/') . '/', $haystack) === 1;
    }
}

// dengan array
/*
    $kode = "2025001";

    // diawali salah satu dari array
    if (starts_with_array($kode, ['2024', '2025'])) {
        echo "✅ Kode dimulai dengan 2024 atau 2025\n";
    }

    // diakhiri salah satu dari array
    if (ends_with_array($kode, ['001', '999'])) {
        echo "✅ Kode diakhiri dengan 001 atau 999\n";
    }

    // mengandung salah satu dari array
    if (contains_array($kode, ['ABC', '25'])) {
        echo "✅ Kode mengandung 'ABC' atau '25'\n";
    }

*/
if (!function_exists('starts_with_array')) {
    /**
     * Cek apakah string diawali dengan salah satu dari teks (array needle)
     */
    function starts_with_array(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (preg_match('/^' . preg_quote($needle, '/') . '/', $haystack)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('ends_with_array')) {
    /**
     * Cek apakah string diakhiri dengan salah satu dari teks (array needle)
     */
    function ends_with_array(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (preg_match('/' . preg_quote($needle, '/') . '$/', $haystack)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('contains_array')) {
    /**
     * Cek apakah string mengandung salah satu dari teks (array needle)
     */
    function contains_array(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (preg_match('/' . preg_quote($needle, '/') . '/', $haystack)) {
                return true;
            }
        }
        return false;
    }
}
// replace
/*
    $text = "Halo Bro, guru kece hadir tahun 2025!";

    $hasil = str_replace_array([
        'Bro'  => 'Boss',
        'guru' => 'Sensei',
        '2025' => '2030'
    ], $text);

    echo $hasil;
    Hasil : Halo Boss, Sensei kece hadir tahun 2030!

*/
if (!function_exists('str_replace_array')) {
    /**
     * str_replace_array
     * -------------------------------------------------
     * Ganti banyak kata/frasa dalam string berdasarkan array.
     *
     * @param array  $replacements  Format: ['cari' => 'ganti', 'lama' => 'baru']
     * @param string $subject       String target
     * @return string
     */
    function str_replace_array(array $replacements, string $subject): string
    {
        return str_replace(array_keys($replacements), array_values($replacements), $subject);
    }
}
/*
Contoh :
    $text = "Kode A123, B456, C789";

    $hasil = preg_replace_array([
        '/[A-Z]/' => 'X',   // semua huruf kapital jadi X
        '/[0-9]/' => '*'    // semua angka jadi *
    ], $text);

    echo $hasil; // Output: Kode X***, X***, X***

*/
if (!function_exists('preg_replace_array')) {
    function preg_replace_array(array $patterns, string $subject): string
    {
        return preg_replace(array_keys($patterns), array_values($patterns), $subject);
    }
}
if (!function_exists('bulanIndo')) {
    /**
     * Mengubah angka bulan menjadi nama bulan dalam Bahasa Indonesia
     * @param int $angkaBulan 1-12
     * @return string|null
     */
    function bulanIndo($angkaBulan)
    {
        $bulan = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $bulan[$angkaBulan] ?? null;
    }
}
/*

$selisih = hitung_selisih($Identitas->trial_ends_at);

echo "Selisih hari: " . $selisih['hari'] . " hari\n";
echo "Selisih jam: " . $selisih['jam'] . " jam\n";
echo "Selisih manusiawi: " . $selisih['manusiawi'] . "\n";
*/

if (!function_exists('hitung_selisih')) {
    function hitung_selisih($tanggal1, $tanggal2 = null)
    {
        // Kalau tanggal2 tidak diisi, gunakan sekarang
        $tgl1 = Carbon::parse($tanggal1);
        $tgl2 = $tanggal2 ? Carbon::parse($tanggal2) : Carbon::now();

        return [
            'hari' => $tgl1->diffInDays($tgl2, false),   // negatif kalau sudah lewat
            'jam' => $tgl1->diffInHours($tgl2, false),   // negatif kalau sudah lewat
            'manusiawi' => $tgl1->diffForHumans($tgl2)  // contoh: "2 days after"
        ];
    }
}

if (!function_exists('cek_hitung_selisih')) {
    function cek_hitung_selisih($tanggalTrial)
    {
        $trial = Carbon::parse($tanggalTrial);
        $now = Carbon::now();

        // Selisih hari positif jika trial belum habis, 0 kalau habis
        $hari = $trial->diffInDays($now, false);

        return [
            'hari' => $hari,                  // bisa negatif kalau sudah habis
            'jam' => $trial->diffInHours($now, false),
            'manusiawi' => $trial->diffForHumans($now),
        ];
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Format Pesan :
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
if (!function_exists('string_to_array')) {
    /**
     * Ubah string "key:value/key2:value2" jadi array associatif
     *
     * @param string $data
     * @param string $itemSeparator Separator tiap item, default '/'
     * @param string $keyValueSeparator Separator key/value, default ':'
     * @return array
     */
    /*
    $data = "nama_siswa:danyrpseta/alamat:dede";
    $array = string_to_assoc($data);
    */
    function string_to_array(string $data, string $itemSeparator = '/', string $keyValueSeparator = ':'): array
    {
        $result = [];
        foreach (explode($itemSeparator, $data) as $item) {
            if (str_contains($item, $keyValueSeparator)) {
                [$key, $value] = explode($keyValueSeparator, $item, 2);
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
if (!function_exists('combine_format_pesan')) {
    function combine_format_pesan($keyMessage, $message)
    {
        $keydata = array_map('trim', explode('/', $keyMessage));
        $values  = array_map('trim', explode('/', $message));

        // Samakan jumlah key & value
        $countKey = count($keydata);
        $countVal = count($values);

        if ($countKey > $countVal) {
            // Tambah null biar gak error combine
            $values = array_pad($values, $countKey, null);
        } elseif ($countVal > $countKey) {
            // Potong kelebihan
            $values = array_slice($values, 0, $countKey);
        }

        return array_combine($keydata, $values);
    }
}
