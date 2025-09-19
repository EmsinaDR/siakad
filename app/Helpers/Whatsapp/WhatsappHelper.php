<?php

use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Admin\Identitas;
use Illuminate\Database\Seeder;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Support\Facades\Http;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Whatsapp\WhatsAppSession;
// use Illuminate\Support\Facades\Http;


// Bersihkan pesan di bagian penjadwalan pesan whatsapp
if (!function_exists('cleanPesanWA')) {
    function cleanPesanWA($html)
    {
        // Ganti <li> dengan bullet
        $html = preg_replace('/<li[^>]*>/i', "• ", $html);
        $html = preg_replace('/<\/li>/i', "\n", $html);

        // Ganti <p> dan <br> dengan newline
        $html = str_ireplace(['<p>', '</p>'], ['', "\n"], $html);
        $html = str_ireplace(['<br>', '<br/>', '<br />'], "\n", $html);

        // Bold dan italic
        $html = str_ireplace(['<strong>', '</strong>', '<b>', '</b>'], '*', $html);
        $html = str_ireplace(['<em>', '</em>', '<i>', '</i>'], '_', $html);

        // Hapus semua sisa tag HTML
        $html = strip_tags($html);

        // Bersihkan spasi/tab berlebihan
        $html = preg_replace('/[ \t]+/', ' ', $html);

        // Gabungkan newline bertumpuk jadi satu
        $html = preg_replace('/\n{2,}/', "\n", $html);

        return trim($html);
    }
}

if (!function_exists('kirimPesanAbsensi')) {
    function kirimPesanAbsensi($id, $data, $session = 'GuruId')
    {

        $faker = Faker::create(); //Simpan didalam code run
        $identitas = Identitas::first();
        $telat = $data['telat'] ?? 0;        // default 0 menit
        $telat = $data['jenisAbsen'] === 'masuk' ? '⏰ Telat      : ' . $telat . ' Menit' : '';        // default 0 menit
        $waktu = $data['waktu'] ?? 'Pagi';  // default "Pagi"
        // Ambil URL gateway dari config atau .env
        $url = config('services.wa_gateway') ?? env('WA_GATEWAY_URL', 'http://127.0.0.1:3000');
        try {
            // Cek status server WA Gateway
            $response = Http::timeout(3)->get("{$url}/status");

            $status = strtolower($response->json('status') ?? '');

            if (!$response->successful() || ($status !== 'connected' && $status !== 'CONNECTED')) {
                return ['status' => 'error', 'message' => '⚠️ Gateway WA tidak aktif'];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => '❌ Tidak dapat terhubung ke gateway',
                'error' => $e->getMessage()
            ];
        }

        $datasiswa = Detailsiswa::with('Detailsiswatokelas')->find($id);
        if (!$datasiswa) {
            return ['status' => 'error', 'message' => '❌ Data siswa tidak ditemukan'];
        }
        $nama = $datasiswa->nama_siswa;
        $kelas = optional($datasiswa->Detailsiswatokelas)->kelas ?? 'Tidak ada';
        $tanggal = now()->translatedFormat('d F Y');
        $jam = now()->format('H:i');
        if (!config('whatsappSession.WhatsappDev')) {
            // Produksi: Kirim ke nomor asli orang tua
            if (!config('whatsappSession.SingleSession')) {
                $session = getWaSessionByTingkat($datasiswa->tingkat_id);
            } else {
                $session = config('whatsappSession.IdWaUtama');
            }
            $noTujuanayahibu = $datasiswa->ayah_nohp ?: $datasiswa->ibu_nohp ?: config('whatsappSession.SekolahNoTujuan');
        } else {
            // Mode dev: Kirim ke nomor dev
            $noTujuanayahibu = config('whatsappSession.DevNomorTujuan');
            $session = config('whatsappSession.IdWaUtama'); //Hapus jika sudah aktif
        }
        // Tentukan nomor tujuan dengan fallback
        $nomorTujuan = $noTujuanayahibu;
        // $nomorTujuan = $datasiswa->ayah_nohp ?: ($datasiswa->nohp_ibu ?: '6285329860005'); // Pengganti fallback

        if (!$nomorTujuan) {
            $nomorTujuan = config('whatsappSession.SekolahNoTujuan'); // fallback hardcoded (boleh diganti) 6285329860005 - 62859148222221
        }
        $Kami = $faker->randomElement(['Kami', 'Sekolah']);
        $Ucapkan = $faker->randomElement(['ucapkan', 'haturkan', 'sampaikan']);
        $Menyampaikan = $faker->randomElement(['menyampaikan', 'informasikan', 'beritahukan']);
        $Disiplin = $faker->randomElement(['disiplin waktu', 'disiplin', 'tepat waktu']);
        // Format pesan absensi

        $message =
            "================================\n" .
            "📌 *LAPORAN ABSENSI HARIAN*\n" .
            "================================\n\n" .
            "Selamat $waktu Bp / Ibu, $Kami $Menyampaikan terkait dengan absensi kehadiran ananda *$nama* sebagai berikut : \n\n" .
            "👨‍🎓 Nama\t\t: $nama\n" .
            "🏫 Kelas\t\t: $kelas\n" .
            "📅 Tanggal\t: $tanggal\n" .
            "⏰ Jam\t\t\t: $jam WIB\n" .
            "📒 Keterangan : *Hadir*\n" .
            "{$telat}\n" .
            "\n" . str_repeat("─", 25) . "\n" .
            "$Kami $Ucapkan banyak terima kasih atas partisipasi Bp / Ibu dalam mengarahkan ananda *$nama* agar selalu $Disiplin" .
            "\n" . str_repeat("─", 25) . "\n" .
            "✍️ Dikirm oleh:\n WhasappBot *{$identitas->namasek}*";
        return WhatsApp::sendMessage($session, $nomorTujuan, $message);
    }
}

if (!function_exists('formatNomorWA')) {
    function formatNomorWA($no_hp)
    {
        $no_hp = preg_replace('/[\s\.\-]/', '', $no_hp);
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }
        if (substr($no_hp, 0, 3) === '+62') {
            $no_hp = '62' . substr($no_hp, 3);
        }
        return $no_hp;
    }
}
if (!function_exists('FiturPaket')) {
    function FiturPaket($paket, $pecahNo)
    {
        $identitas = Identitas::first();
        if ($paket === 'Kerjasama') {
            $sessions = config('whatsappSession.IdWaUtama');
            $message =
                "================================\n" .
                "📌 *INFORMASI*\n" .
                "================================\n\n" .
                "Pesan ini hanya bisa diakses kerjasama pada paket *Premium*\n\n" .
                "Vendor : Ata Digital\n" .
                "Kontak : 6285329860005\n" .
                "\n" . str_repeat("─", 25) . "\n" .
                "✍️ Dikirm oleh:\n *Ata Digital* via WhasappBot *{$identitas->namasek}*";
            \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $pecahNo, $message);

            exit; // << STOP TOTAL, tidak lanjut ke bawah
        }
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Whatsapp Session :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - Memilih Mode Dev dan Prod
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
if (!function_exists('getWaSessions')) {
    function getWaSessions(): array
    {
        if (!config('whatsappSession.WhatsappDev')) {
            return WhatsAppSession::pluck('akun_id')->toArray();
        }

        return [config('whatsappSession.IdWaUtama')];
    }
}

/*
    |--------------------------------------------------------------------------
    | 📌 Pemilihan Session untuk tingkat tertentu :
    |--------------------------------------------------------------------------
    | Penggunaan : $session = getWaSessionByTingkat($datasiswa->tingkat_id);
    */
// Proses Coding
if (!function_exists('getWaAcakSessionByTingkat')) {
    function getWaAcakSessionByTingkat($tingkat_id)
    {
        // $PilihSession = WhatsAppSession::where('tingkat_id', $tingkat_id)->pluck('akun_id')->get();
        // Memilih secara random jika Admin banyak berdasarkan tingkat
        $faker = Faker::create(); //Simpan didalam code run
        $PilihSession = WhatsAppSession::where('tingkat_id', $tingkat_id)->pluck('akun_id')->toArray();
        if (!empty($PilihSession)) {
            // Kalau ada datanya, pilih salah satu secara acak
            $sessionId = $faker->randomElement($PilihSession);
        } else {
            // Kalau kosong, fallback ke konfigurasi default
            $sessionId = config('whatsappSession.IdWaUtama');
        }

        return $sessionId;
        // return match ((int) $tingkat_id) {
        //     7 => 'AdminA',
        //     8 => 'AdminB',
        //     9 => 'AdminC',
        //     default => null
        // };
    }
}
if (!function_exists('getWaSessionByTingkat')) {
    function getWaSessionByTingkat($tingkat_id)
    {
        $faker = Faker::create(); // Simpan di dalam function
        $PilihSession = WhatsAppSession::where('tingkat_id', $tingkat_id)->pluck('akun_id')->toArray();

        if (!empty($PilihSession)) {
            // Kalau ada datanya, pilih salah satu secara acak
            $sessionId = $faker->randomElement($PilihSession);
        } else {
            // Kalau kosong, fallback ke konfigurasi default
            $sessionId = config('whatsappSession.IdWaUtama');
        }

        return $sessionId;
    }
}

/*
    |--------------------------------------------------------------------------
    | 📌 Pengambilan Data GroupId :
    |--------------------------------------------------------------------------
    |
    | Fitur :
    | - Data Group Id
    | - xxxxxxxxxxx
    |
    | Tujuan :
    | - Pengambilan groupId untuk pengiriman pesan ke group
    | -
    |
    |
    | Penggunaan :
    | - getGroupsBySession : WhatsAppController untuk parse ke dropdown melalui ajax di penjadwalan-pesan
    |
    */
// Proses Coding
if (!function_exists('getGroups')) {
    function getGroups($sessionId)
    {
        $host = config('app.whatsapp_host', '127.0.0.1');
        $url = "http://{$host}:3000/get-groups?id={$sessionId}";

        try {
            $response = Http::get($url);
            return $response->json();
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Gagal ambil daftar grup: ' . $e->getMessage()
            ];
        }
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Hapus Id :
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
    $success = hapusSessionWwebjs('abc123');

    if ($success) {
        echo "Session berhasil dihapus!";
    } else {
        echo "Gagal menghapus session!";
    }

    */
// Proses Coding
if (!function_exists('hapusSessionWwebjs')) {
    /**
     * Hapus session .wwebjs_auth berdasarkan sessionId
     *
     * @param string $sessionId
     * @return bool
     */
    function hapusSessionWwebjs(string $sessionId): bool
    {
        // escape supaya aman dari karakter spesial
        $escapedSessionId = escapeshellarg($sessionId);

        // perintah bash
        $command = "rm -rf .wwebjs_auth/session-{$escapedSessionId}";
        exec($command, $output, $returnVar);
        return $returnVar === 0;
    }
}

if (!function_exists('AbsensiPulangCepat')) {
    function AbsensiPulangCepat($siswa, $keterangan)
    {
        //Isi Fungsi
        $hariIni = Carbon::create(now())->translatedformat('l, d F Y');
        $jam = Carbon::create(now())->translatedformat('H:i');
        $isi =
            "\nDi informasikan kepada Bapak / Ibu Wali dari *Ananda {$siswa->nama_siswa}*\n" .
            "Hari ini {$hariIni}\n" .
            "dikarenakan ada *Kegiatan {$keterangan}*, sekolah memutuskan mulai {$jam} WIB, Siswa belajar dirumah masing - masing ( Belajar Dirumah ). \n" .
            "Sekian informasi yang dapat disampaikan, atas segala perhatian kami sampaikan banyak terima kasih. \n" .
            "\n";
        return $isi;
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 Cari No Yjuan :
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
        $nomorTujuan = getNoTujuanOrtu($datasiswa);
    |
    */
// Proses Coding
if (!function_exists('getNoTujuanOrtu')) {
    /**
     * Dapatkan nomor WhatsApp orang tua dengan prioritas Ibu > Ayah > fallback
     *
     * @param object $datasiswa
     * @return string
     */
    function getNoTujuanOrtu($siswa)
    {
        if (!config('whatsappSession.WhatsappDev')) {
            // Produksi: Prioritas Ibu, lalu Ayah, lalu IdWaUtama
            $nomor = $siswa->ibu_nohp ?: ($siswa->ayah_nohp ?: config('whatsappSession.SekolahNoTujuan'));
        } else {
            // Mode dev: nomor dev
            $nomor = config('whatsappSession.DevNomorTujuan');
        }

        // fallback tambahan kalau nomor masih kosong
        if (!$nomor) {
            $nomor = config('whatsappSession.SekolahNoTujuan');
        }

        return $nomor;
    }
}
/*
    |--------------------------------------------------------------------------
    | 📌 getWaSession :
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
if (!function_exists('getWaSession')) {
    /**
     * Dapatkan session WhatsApp berdasarkan mode SingleSession atau per tingkat
     *
     * @param int|null $tingkat_id
     * @return string
     * Null kan jika ingin pake IdUtama
     */
    function getWaSession($tingkat_id = null)
    {
        // Jika mode SingleSession aktif, pakai session utama
        if (config('whatsappSession.SingleSession')) {
            return config('whatsappSession.IdWaUtama');
        }

        // Kalau bukan SingleSession, pakai session per tingkat
        if ($tingkat_id) {
            return getWaSessionByTingkat($tingkat_id);
        }

        // fallback jika tingkat_id tidak tersedia
        return config('whatsappSession.IdWaUtama');
    }
}
if (!function_exists('getWhatsappConfig')) {
    /**
     * Ambil konfigurasi session & nomor tujuan WhatsApp
     *
     * @param object $siswa
     * @return array [sessions, nomor]
     */
    function getWhatsappConfig($siswa): array
    {
        // Kalau bukan mode Dev
        if (!config('whatsappSession.WhatsappDev')) {

            // SingleSession atau multi per tingkat
            $sessions = !config('whatsappSession.SingleSession')
                ? getWaSession($siswa->tingkat_id)
                : getWaSession();

            $NoTujuan = getNoTujuanOrtu($siswa);
        } else {
            // Kalau Dev, pakai session & nomor dummy
            $sessions = config('whatsappSession.IdWaUtama');
            $NoTujuan = config('whatsappSession.DevNomorTujuan');
        }

        return [
            'sessions' => $sessions,
            'nomor'    => $NoTujuan,
        ];
    }
}
// Cek No Valid
function isWhatsappRegistered(string $nomor, string $sessionId): bool
{
    try {
        $response = Http::get('http://127.0.0.1:3000/isregister', [
            'id' => $sessionId,
            'number' => $nomor
        ]);

        if ($response->successful()) {
            $hasil = $response->json();
            return !empty($hasil['isRegistered']) && $hasil['isRegistered'] === true;
        }
    } catch (\Exception $e) {
        // Opsional: log error
        // \Log::error('WA check error: ' . $e->getMessage());
    }

    return false; // fallback kalau gagal
}
