<?php

namespace App\Http\Controllers\Whatsapp;

// app\Http\Controllers\WhatsAppController.php

use App\Console\Commands\Whatsapp\WhatsappSessionCek;
use Imagick;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Http\Request;
use App\Models\bk\Bkbimbingan;
use App\Models\Admin\Identitas;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\bk\Ebkpelanggaran;
use App\Models\Whatsapp\WhatsApp;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use App\Models\User\Guru\Detailguru;
use App\Models\Whatsapp\WhatsappLog;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\Absensi\DataIjinDigital;

use function App\Helpers\DataSiswaAllx;
use Spatie\PdfToImage\Pdf as pdfSpatie;
use App\Models\Whatsapp\WhatsAppSession;
use Illuminate\Support\Facades\Redirect;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;
use Database\Seeders\Ekstra\EekstradhSeeder;

class WhatsAppController extends Controller
{
    private function getWhatsappApiUrl()
    {
        return rtrim(config('whatsapp.gateway_url', 'http://127.0.0.1:3000/'), '/') . '/';
    }
    // E:\laragon\www\siakad\app\Http\Controllers\WhatsAppController.php
    /*



const cors = require('cors');
app.use(cors()); // izinkan semua origin



*/
    public function getStatus()
    {
        try {
            $host = request()->getHost(); // contoh: 192.168.1.9
            $url = "http://{$host}:3000/status";

            $response = Http::timeout(3)->get($url);

            if (
                !$response->successful() ||
                strtolower($response->json('status')) !== 'connected'
            ) {
                return response()->json(['status' => '⚠️ Server WhatsApp JS belum aktif'], 500);
            }

            return response()->json(['status' => 'CONNECTED']);
        } catch (\Exception $e) {
            return response()->json(['status' => '⚠️ Server WhatsApp JS belum aktif', 'error' => $e->getMessage()], 500);
        }
    }
    public function GetMember(Request $request)
    {
        $title = 'Data Group';
        $breadcrumb = 'Admin / Anggota Group';
        $host = config('app.whatsapp_host', '127.0.0.1');
        $url = "http://{$host}:3000";

        $groups = getGroups(config('whatsappSession.IdWaUtama'));
        $members = [];
        $groupName = 'Nama grup tidak tersedia';

        $groupId = $request->GroupId;

        // Cari nama grup dari list grup
        if ($groups['status'] === true) {
            foreach ($groups['groups'] as $group) {
                if ($group['id'] === $groupId) {
                    $groupName = $group['name'] ?? $group['subject'] ?? 'Nama grup tidak tersedia';
                    break;
                }
            }
        }

        // Ambil anggota grup lewat API
        $response = Http::get("{$url}/group-members/{$groupId}", [
            'id' => config('whatsappSession.IdWaUtama')
        ]);

        if ($response->successful()) {
            $members = $response->json() ?? [];
        } else {
            $members = []; // fallback jika gagal
        }

        return view('whatsapp.whatsapp-member', compact(
            'title',
            'breadcrumb',
            'sessions',
            'groups',
            'members',
            'groupName',
            'groupId'
        ));
    }

    public function whatsappqrcode()
    {
        $title = 'Scan QrCode';
        $breadcrumb = 'Admin / Whatsaap QrCode';
        $DataSessionNames = Cache::tags(['cache_DataSessionNames'])->remember('remember_DataSessionNames', now()->addHours(2), function () {
            return WhatsAppSession::get();
        });
        // $sessions = Http::get("$this->getWhatsappApiUrl()/sessions")->json();
        $sessions = getGroups(config('whatsappSession.IdWaUtama'));
        $groups = getGroups(config('whatsappSession.IdWaUtama'));
        $whatsappAkuns = WhatsAppSession::get();
        return view('whatsapp.whatsapp', compact(
            'title',
            'breadcrumb',
            'sessions',
            'DataSessionNames',
            'groups',
            'whatsappAkuns',
        ));
        // return 'ddd';
    }
    public function SendGroupMedia(Request $request)
    {
        // dd($request->all());

        $sessionId = $request->input('sessionId') ?: config('whatsappSession.IdWaUtama');

        $Group = $request->input('groupId', []); // Bisa juga nomor pribadi
        $NomorGuru = $request->input('nomor_guru', []); // Bisa juga nomor pribadi

        $receivers = array_merge($Group, $NomorGuru);

        // hapus elemen kosong
        $receivers = array_filter($receivers, fn($val) => !empty($val));
        // dd($receivers);
        $caption = cleanPesanWA($request->input('caption')); // Filter gaya pesan

        $media = $request->file('media');
        $defaultMediaPath = public_path('img/logo.png'); // file default

        if ($media) {
            // kalau ada upload, simpan ke folder uploads
            $filename = time() . '_' . $media->getClientOriginalName();
            $media->move(base_path('whatsapp/uploads'), $filename);
            $filePath = base_path('whatsapp/uploads/' . $filename);
        } else {
            // kalau tidak ada upload, pakai file default
            $filePath = $defaultMediaPath;
            $filename = 'logo.png';
        }

        $host = config('app.whatsapp_host', '127.0.0.1');
        $url = "http://{$host}:3000/send-media-file";

        try {
            foreach ($receivers as $number) {
                $response = Http::attach(
                    'media',
                    file_get_contents($filePath),
                    $filename
                )->post($url, [
                    'id' => $sessionId,
                    'number' => $number,
                    'caption' => $caption
                ]);
            }

            return redirect()->route('penjadwalan.index')->with('success', 'Pesan telah dikirim!');
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal kirim media: ' . $e->getMessage()
            ], 500);
        }
    }


    public function SendGroupMediaMulter(Request $request)
    {
        // dd($request->all());
        $sessionId = $request->input('sessionId', config('whatsappSession.IdWaUtama'));
        $receivers = $request->input('groupId'); // Bisa juga nomor pribadi
        $caption = $request->input('caption'); // Filter gaya pesan
        $caption = cleanPesanWA($request->input('caption')); // Filter gaya pesan

        $media = $request->file('media');

        if (!$media) {
            return response()->json([
                'status' => false,
                'message' => 'File tidak ditemukan.'
            ], 400);
        }

        $filename = time() . '_' . $media->getClientOriginalName();
        $media->move(base_path('whatsapp/uploads'), $filename);
        $filePath = base_path('whatsapp/uploads/' . $filename);

        $host = config('app.whatsapp_host', '127.0.0.1');
        $url = "http://{$host}:3000/send-media-file";

        try {
            foreach ($receivers as $number) {
                $response = Http::attach(
                    'media',
                    file_get_contents($filePath),
                    $filename
                )->post($url, [
                    'id' => $sessionId,
                    'number' => $number,
                    'caption' => $caption
                ]);

                // $results[] = $response->json();
            }
            return redirect()->route('penjadwalan.index')->with('success', 'Pesanmu mantap!');

            return $results;
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal kirim media: ' . $e->getMessage()
            ], 500);
        }
    }

    public function responAktif()
    {
        // http://localhost/siakad/public/respon-aktif
        // Ambil semua akun_id dari tabel
        $sessions = WhatsAppSession::all(['akun_id']);
        if ($sessions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada akun_id ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'akun_ids' => $sessions->pluck('akun_id')
        ]);
    }


    public function kirimpesan()
    {
        $title = 'Kirim Pesan Whatsapp';
        $breadcrumb = 'Kirim Pesan / Siswa';
        // $sessions = Http::get("$this->getWhatsappApiUrl()/sessions")->json();
        $sessions = 'Siswa';
        // $sessions = 'ferda';
        // $pesan = new WhatsApp();
        // $pesan = $pesan->NotifikasiWa();
        $number = '6285329860005';
        $nama = 'Dany Rosepta';
        $kelas = 'VII A';
        $waktuAbsen = Carbon::create(now()); // Set tanggal ke 2 September 2029
        $formattedDate = $waktuAbsen->translatedFormat('j F Y'); // Format: "2 September 2029"
        $jam = $waktuAbsen->format('H:i:s');

        $message =
            "==================================\n" .
            "📌 *LAPORAN ABSENSI*\n" .
            "==================================\n\n" .
            "📝 Nama\t\t\t\t\t\t\t: $nama\n" .
            "🏫 Kelas\t\t\t\t\t\t\t: $kelas\n" .
            "📅 Tanggal Absen\t: $formattedDate\n" .
            "⏰ Jam Absen\t\t: $jam\n" .
            "\n" . str_repeat("─", 25) . "\n" . // Garis pemisah
            "✍️ Ditandatangani oleh:\n" .
            "   $nama\n";
        //Bukti Pembayaran
        $totalBayar = 25000;
        $metodePembayaran = 'Tunai';
        $message
            =
            // "==================================\n" .
            "\n" .
            "💳 *BUKTI PEMBAYARAN*\n" .
            "==================================\n\n" .
            "👤 *Nama Siswa:* $nama\n" .
            "🛍️ *Pembayaran:* SPP\n" .
            "💰 *Total Bayar:* Rp " . number_format($totalBayar, 0, ',', '.') . "\n" .
            "🗓️ *Tanggal Pembayaran:* $formattedDate\n" .
            "⏰ *Jam Pembayaran:* $jam\n" .
            "💳 *Metode Pembayaran:* $metodePembayaran\n" .
            "\n" . str_repeat("─", 25) . "\n" . // Garis pemisah
            "✍️ *Ditandatangani oleh:*\n" .
            "$nama";
        $totalBayar = 25000;
        $metodePembayaran = 'Tunai';
        $batasWaktu = Carbon::now()->addDays(10); // Carbon object
        $formattedDate = Carbon::now()->addDays(10)->translatedFormat('j F Y');

        $message
            =
            // "==================================\n" .
            "\n" .
            "💳 *INFORMASI PEMBAYARAN*\n" .
            "==================================\n\n" .
            "👤 *Nama Siswa\t\t\t\t:* $nama\n" .
            "🛍️ *Pembayaran\t\t\t\t:* SPP\n" .
            "💰 *Total Tagihan\t\t\t:* Rp " . number_format($totalBayar, 0, ',', '.') . "\n" .
            // "🗓️ *Tanggal\t\t\t\t\t\t\t:* $formattedDate\n" .
            "⏳ *Batas Waktu*\t\t\t\t: $formattedDate\n" .
            "\n" . str_repeat("─", 25) . "\n" . // Garis pemisah
            "✍️ *Ditandatangani oleh:*\n" .
            "$nama";

        // $message = 'Ini%20baris%20pertama.
        // %0AIni%20baris%20kedua.';
        // Ini%20baris%20pertama.%0AIni%20baris%20kedua.
        $sessions = config('whatsappSession.IdWaUtama');
        //6285329860005
        // 6282324399566

        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, '6285329860005', $message);
        // $result = WhatsApp::sendMessage($request->session_id, $request->number, $request->message);

        return response()->json($result);
        // return view('whatsapp.kirim-pesan', compact('title', 'breadcrumb', 'sessions'));
        // return 'ddd';
    }
    public function create()
    {
        try {
            //   content
        } catch (Exception $e) {
            // Tindakan jika terjadi exception
            return Redirect::back()->with('Title', 'Gagal')->with('gagal', 'Gagal tidak dikenali');
        }
    }
    public function createSession(Request $request)
    {
        $sessionName = $request->session_name;
        $baseUrl = $this->getWhatsappApiUrl();
        $response = Http::post("$baseUrl/session/$sessionName/start");

        return redirect()->back();
    }

    public function deleteSession($sessionName)
    {
        $baseUrl = $this->getWhatsappApiUrl();
        Http::delete("$baseUrl/session/$sessionName");
        return redirect()->back();
    }

    public function sendMessage(Request $request)
    {
        $data = [
            'session' => $request->session,
            'number' => $request->number,
            'message' => $request->message
        ];
        $baseUrl = $this->getWhatsappApiUrl();

        Http::post("$baseUrl()/send-message", $data);
        return redirect()->back();
    }

    public function sendFile(Request $request)
    {
        $data = [
            'session' => $request->session,
            'number' => $request->number,
            'file' => $request->file_url,
            'caption' => $request->caption
        ];

        $baseUrl = $this->getWhatsappApiUrl();
        Http::post("$baseUrl/send-file", $data);
        return redirect()->back();
    }
    public function sendMessagePembayaran(Request $request)
    {
        $number = $request->input('number');
        $message = $request->input('message');

        $baseUrl = $this->getWhatsappApiUrl();

        $response = Http::post("$baseUrl/send-message", [ // ✅ pakai double quote
            'number' => $number,
            'message' => $message
        ]);


        return response()->json($response->json());
    }
    public function testAutoReply(Request $request)
    {
        $Identitas = Identitas::first();
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $Identitas = Identitas::first();
        $paket = $Identitas->paket;
        $nosession  = explode('@', $request->query('nosession')); // nomor tujuan / session WA
        $nosessionNo = $nosession[0];
        $pecahNo = explode('@', $request->query('number'));
        $NoRequest = $pecahNo[0];
        $number = $request->query('number');
        $message = $request->query('message');
        $message = preg_replace('/\s*\/\s*/', '/', $message);

        if (!$message) {
            $message =  'Media File';
        }
        // Kode Pesan masuk ada gambar ( file pathnya ga )
        $filePath = $request->query('filePath');
        $newFilePath = null;
        // Kalau ada filePath, pindahkan ke folder basepath Laravel
        if ($filePath && file_exists($filePath)) {
            $filename = basename($filePath); // Nama File
            $reply = "Balasan otomatis dari Laravel";
            $destination = storage_path('app/public/uploads/' . $filename); // Folder dilaravel
            // Pindahkan file dari NodeJS WA server ke storage Laravel
            copy($filePath, $destination); // bisa pakai move() kalau mau hapus file lama
            $newFilePath = $destination;
            return response()->json([
                'reply' => $newFilePath,
                // 'file' => $newFilePath
            ]);
            // $message = 'Media File';
            return $message;
        }

        // Cek single Session tidak
        if (!config('whatsappSession.SingleSession')) {
            // Pengecekan sesi yang digunakan
            if ($NoRequest === config('whatsappSession.DevNomorTujuan')) {
                $sessions = config('whatsappSession.IdWaUtama'); // untuk dev syarat dev harus login
            } else {
                $cekSession = WhatsAppSession::where('no_hp', $nosessionNo)->first();
                // $inisession = json_encode($cekSession);
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage('GuruId', '6285329860005', config('whatsappSession.DevNomorTujuan') . "/ dev wa / {$inisession} / " . $nosessionNo);
                $sessions = $cekSession ? $cekSession->akun_id : config('whatsappSession.IdWaUtama');
                // $sessions = $cekSession->akun_id; // untuk umum
            }
        } else {
            $sessions = config('whatsappSession.IdWaUtama');
        }
        // $sessions = config('whatsappSession.IdWaUtama');

        // $baris = preg_split("/\r\n|\n|\r/", $message);
        $baris = preg_replace("/\r\n|\n|\r/", "/", $message);
        // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, '6285329860005', $baris);
        // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, '6285329860005', config('whatsappSession.DevNomorTujuan') . "/ dev wa / " . $nosessionNo);
        // return false;

        if (in_array($paket, ['Kerjasama', 'Premium'])) {
            $newpesan = explode('/', $message);
            $jmlhpesan = count($newpesan);
            if (count($newpesan) === 1) {
                $sumber = $request->query('number');
                // Cek apakah pesan masuk dari group
                if (!empty($sumber) && str_contains($sumber, '@g.us')) {
                    // Balas ke group, bukan ke nomor pribadi pengirim
                    $sessions = config('whatsappSession.IdWaUtama');
                    $pesanKiriman = HelpGroup($message);
                    $filename = 'logo.png';
                    $sumberId = explode('@', $sumber);
                    $filePath = base_path('whatsapp/uploads/logo.png');
                    $sumbers = ['120363403439886403@g.us'];
                    $host = config('app.whatsapp_host', '127.0.0.1');
                    $url = "http://{$host}:3000/send-media-file";

                    try {
                        $response = Http::attach(
                            'media',
                            file_get_contents($filePath),
                            $filename
                        )->post($url, [
                            'id' => $sessions,
                            'number' => $number,
                            'caption' => $pesanKiriman
                        ]);
                    } catch (\Exception $e) {
                        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, 'Gagal Kirim');
                    }
                } else {
                    // Nomor pribadi
                    $pesanKiriman = HelpPesan($message, $NoRequest);
                    $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
                    return false;
                }
            } else {
                $Kode = ucfirst($newpesan[0]); //Pembayaran, BK, Absensi Contoh : Pembayaran/02091989
                $Part0 = ucfirst($newpesan[0]); //xxx/Guru or Siswa/xxxx
                $Part1 = ucfirst($newpesan[1]); //
                $Part2 = $newpesan[2] ?? Null; //xxx/xxxx/nis or kode guru
                $Siswa = \App\Models\User\Siswa\Detailsiswa::with('KelasOne')->where('nis', $Part2)->first();
                $Guru = Detailguru::where('kode_guru', $Part2)->first();
                // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, '6285329860005', config('whatsappSession.DevNomorTujuan') . "/ dev wa / " . $nosessionNo);
                // return false;
                if ($Part1 === 'Siswa') {
                    if (!$Siswa) {
                        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, "Data siswa tidak ditemukan.");
                        return;
                    }
                    Auto_reply_SiswaKode($Siswa, $NoRequest, $message);
                    return false;
                } elseif ($Part1 === 'Surat') {
                    $isi = SuratKode($NoRequest, $message);
                    // return response()->json([
                    //     'status' => 'success',
                    //     'reply' => $isi['pesan'],
                    //     'file' => 'uploads/' . $isi['nama_file'], //Jika ingin kirim via Whatsapp harus simpan di folder upload whatsapp,
                    // ]);
                } elseif ($Part1 === 'Guru') {
                    Auto_reply_Data_Guru($Kode, $NoRequest, $message, $sessions);
                } elseif ($Part1 === 'Cari') {
                    $data = explode('/', $message);
                    Auto_reply_CariKode($Kode, $Siswa, $NoRequest, $message);
                } elseif ($Part1 === 'Alumni') {
                    // handling cek guru
                    // FiturPaket($paket, $NoRequest);
                    Auto_reply_alumni($Kode, $NoRequest, $message);
                } elseif ($Part1 === 'BK') {
                    // handling cek guru
                    FiturPaket($paket, $NoRequest);
                    Auto_reply_BK($Kode, $Siswa, $NoRequest, $message);
                } elseif ($Part1 === 'PPDB') {
                    // handling cek guru
                    FiturPaket($paket, $NoRequest);
                    Auto_Reply_PPDBHelper($Kode, $Siswa, $NoRequest, $message);
                } elseif ($Part1 === 'Database') {
                    // handling cek guru
                    FiturPaket($paket, $NoRequest);
                    Auto_Reply_Database($Kode, $Siswa, $NoRequest, $message);
                } elseif ($Part1 === 'Control') {
                    // handling cek guru
                    // FiturPaket($paket, $NoRequest);
                    Auto_Reply_ControlHelper($Kode, $NoRequest, $message);
                } elseif ($Part1 === 'Operator') {
                    // handling cek guru
                    // FiturPaket($paket, $NoRequest);
                    Auto_Reply_OperatorHelper($Kode, $NoRequest, $message);
                } elseif ($Part1 === 'Kepala') {
                    // handling cek guru
                    // FiturPaket($paket, $NoRequest);
                    $dataFile = Auto_Reply_KepalaHelper($Kode, $NoRequest, $message);
                    // return response()->json([
                    //     'status' => 'success',
                    //     'reply' => "Dokumen siap - " . $dataFile['filename'],
                    //     'file' => 'uploads/' . $dataFile['filename'], //Jika ingin kirim via Whatsapp harus simpan di folder upload whatsapp,
                    // ]);
                } elseif ($Part1 === 'Vendor') {
                    // handling cek guru
                    // FiturPaket($paket, $NoRequest);
                    Auto_Reply_VendorHelper($Kode, $NoRequest, $message, config('whatsappSession.IdWaUtama'));
                    // Auto_Reply_Database($Kode, $Siswa, $NoRequest, $message);
                } elseif ($Part1 === 'Rapat') {
                    // handling cek guru
                    switch ($Kode) {
                        case 'Data Rapat':
                            $Guru = Detailguru::where('kode_guru', $Part2)->first();
                            // Log::info("Request received: Number - $number, Nis - $nis dan Kode = $Kode");
                            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest,  DataKodeGuru($Guru->id));
                            break;
                        default:
                            $pesanKiriman = "Kode Pesan anda *$Kode* Tidak ditemukan";
                            break;
                    }
                } else {
                    // $sessions = config('whatsappSession.IdWaUtama');
                    // $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, 'Zona Guru');
                }
            }
        } else {
            // $sessions = config('whatsappSession.IdWaUtama');
            $sessions = config('whatsappSession.IdWaUtama');
            $pecahNo = explode('@', $request->query('number'));
            $NoRequest = $pecahNo[0];
            $pesanKiriman = 'Anda tidak bisa megakses fitur ini karena sekolah tidak ada kerjasama dengan *Ata Digital*';
            $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $NoRequest, $pesanKiriman);
            // Simpa ke lo pengiriman pesan

            // return response()->json([
            //     'status' => 'success',
            //     // 'message' => $message,
            //     'reply' => "Pesan telah diteruskan"
            // ]);
        }
    }
    public function handleAutoReply(Request $request)
    {
        $Identitas = Identitas::first();

        // Cek akses berdasarkan paket
        if (in_array($Identitas->paket, ['Nonaktif', 'Kadaluarsa'])) {
            return response()->json(['status' => 'error', 'message' => 'Akun Anda tidak aktif']);
        }

        // Ambil parameter dari WhatsApp Gateway
        $number = $request->query('number');
        $message = $request->query('message');
        $pecahNo = explode('@', $number);
        $Parts = explode('/', $message);

        $Kode  = $Parts[0] ?? null;
        $arg1  = $Parts[1] ?? null;
        $arg2  = $Parts[2] ?? null;
        // Hak akses per fitur
        $paketUser = $Identitas->paket ?? 'Gratis';
        $fiturTerbatas = [
            'Pembayaran'            => ['Premium', 'Kerjasama'],
            'BK'                    => ['Premium'],
            'Data Siswa'            => ['Premium', 'Kerjasama'],
            'Absensi'               => ['Premium'],
            'Kelulusan'             => ['Premium'],
            'Jadwal Ekstra'         => ['Premium', 'Kerjasama'],
            'Surat Aktif'           => ['Premium'],
            // Surat Aktif Mengajar
            'SPPD'                  => ['Premium'],
            'Surat Aktif Mengajar'   => ['Premium'],
            'Surat Aktif Mengajar'   => ['Premium'],
        ];

        // Cek hak akses fitur
        if (isset($fiturTerbatas[$Kode]) && !in_array($paketUser, $fiturTerbatas[$Kode])) {
            return response()->json([
                'status' => 'error',
                'message' => "Fitur *$Kode* tidak tersedia untuk paket *$paketUser*. Upgrade ke Premium untuk akses penuh."
            ]);
        }

        $pesanKiriman = "Format pesan salah. Gunakan format yang sesuai, misal: *Kode/NIS*";

        switch ($Kode) {
            case 'Pembayaran':
            case 'BK':
            case 'Absensi':
            case 'Kelulusan':
            case 'Data Siswa':
                $Siswa = \App\Models\User\Siswa\Detailsiswa::with('KelasOne')->where('nis', $arg1)->first();

                if (!$Siswa) {
                    $pesanKiriman = 'Data Siswa Tidak Ditemukan. Periksa kembali *NIS* dan *Format Pesan*.';
                    break;
                }

                $Nama  = $Siswa->nama_siswa;
                $Kelas = $Siswa->Detailsiswatokelas->kelas ?? '-';
                $Nis   = $Siswa->nis;

                switch ($Kode) {
                    case 'Pembayaran':
                        $pesanKiriman = $this->formatPesan($Kode, [
                            'Nama' => $Nama,
                            'Kelas' => $Kelas,
                            'Total Pembayaran' => 'Rp 250.000' // Nanti bisa ambil dari DB
                        ]);
                        break;

                    case 'BK':
                        $pesanKiriman = $this->formatPesan($Kode, [
                            'Nama' => $Nama,
                            'Kelas' => $Kelas,
                            'Jumlah Point' => 'Point' // Bisa disesuaikan
                        ]);
                        break;

                    case 'Absensi':
                        $pesanKiriman = $this->formatPesan($Kode, [
                            'Nama' => $Nama,
                            'Kelas' => $Kelas,
                            'Absensi' => 'Hadir / Tidak Hadir'
                        ]);
                        break;

                    case 'Kelulusan':
                        $pesanKiriman = $this->formatPesan($Kode, [
                            'Nama' => $Nama,
                            'Kelas' => $Kelas,
                            'Tanggal' => 'tanggal kelulusan'
                        ]);
                        break;

                    case 'Data Siswa':
                        $KelasObj = \App\Models\Admin\Ekelas::with('kelastoDetailguru')->find($Siswa->kelas_id);
                        $pesanKiriman = $this->formatPesan($Kode, [
                            'Nama' => $Nama,
                            'Kelas' => $KelasObj->kelas ?? '-',
                            'NIS' => $Nis,
                            'Alamat Siswa' => $Siswa->alamat_siswa,
                            'Wali Kelas' => $KelasObj->kelastoDetailguru->nama_guru ?? '-'
                        ]);
                        break;
                }
                break;

            case 'Jadwal Ekstra':
                $Ekstras = Ekstra::get();
                $pesanKiriman = "📌 *Data Jadwal Ekstrakurikuler*\n\n";
                foreach ($Ekstras as $ekstra) {
                    $pesanKiriman .= $this->formatPesan("Ekstra", [
                        'Nama Ekstra' => $ekstra->ekstra,
                        'Pembina' => $ekstra->pembina,
                        'Pelatih' => $ekstra->pelatih,
                        'Hari' => $ekstra->jadwal
                    ], false);
                }
                break;

            case 'Surat Aktif':
                $Siswa = \App\Models\User\Siswa\Detailsiswa::where('nis', $arg1)->first();
                if (!$Siswa) {
                    $pesanKiriman = "NIS tidak ditemukan.";
                    break;
                }
                $pesanKiriman = $this->formatPesan("Surat Aktif", [
                    'Nama' => $Siswa->nama_siswa,
                    'Kelas' => $Siswa->Detailsiswatokelas->kelas ?? '-',
                    'Status' => 'Aktif'
                ]);
                break;

            case 'SPPD':
                $Guru = Detailguru::where('kode_guru', $arg1)->first();
                if (!$Guru) {
                    $pesanKiriman = "Kode Guru tidak ditemukan.";
                    break;
                }
                // SPPD/KodeGuru/Tujuan Perjalanan Dinas/Tempat Pelaksanaan/Tanggal/Waktu/Tanda Tangan
                $Kode  = $Parts[0] ?? null;
                $arg1  = $Parts[1] ?? null;
                $arg2  = $Parts[2] ?? null;

                $pesanKiriman = $this->formatPesan("SPPD", [
                    'Nama Guru' => $Guru->nama,
                    'Acara' => $arg2 ?? '-',
                    'Tanggal' => now()->format('d-m-Y')
                ]);
                break;
            case 'Surat Aktif Mengajar':
                $Guru = Detailguru::where('kode_guru', $arg1)->first();
                if (!$Guru) {
                    $pesanKiriman = "Kode Guru tidak ditemukan.";
                    break;
                }
                $pesanKiriman = $this->formatPesan("SPPD", [
                    'Nama Guru' => $Guru->nama,
                    'Acara' => $arg2 ?? '-',
                    'Tanggal' => now()->format('d-m-Y')
                ]);
                break;

            default:
                $pesanKiriman = "Kode pesan *$Kode* tidak dikenal. Cek kembali format dan kode yang digunakan.";
                break;
        }

        // Kirim dan simpan log

        $pecahNo = explode('@', $request->query('number'));
        $NoRequest = $pecahNo[0];
        Log::info("Request WA: Number=$number | Kode=$Kode | Arg1=$arg1");
        \App\Models\Whatsapp\WhatsApp::sendMessage(config('whatsappSession.IdWaUtama'), $NoRequest, $pesanKiriman);

        return response()->json([
            'status' => 'success',
            'reply' => 'Pesan telah diteruskan'
        ]);
    }
    // proses pengambilan data group sesuai sessionId
    public function getGroupsBySession(Request $request)
    {
        $sessionId = $request->sessionId;
        // Asumsikan kamu punya helper getGroups($sessionId)
        $groups = getGroups($sessionId); // ⛏️ Tarik datanya

        return response()->json([
            'status' => true,
            'groups' => $groups
        ]);
    }


    private function formatPesan($judul, array $data, $withHeader = true)
    {
        $text = '';

        if ($withHeader) {
            $text .= "==================================\n";
            $text .= "📌 *Data $judul*\n";
            $text .= "==================================\n\n";
        }

        foreach ($data as $label => $value) {
            $text .= "🔹 $label\t: $value\n";
        }

        $text .= "\n" . str_repeat("─", 25) . "\n";
        $text .= "✍️ Dikirim oleh:\n";
        $text .= "   *Boot Assiten Pelayanan*\n";

        return $text;
    }
}
