<?php

namespace App\Models\Whatsapp;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class WhatsApp extends Model
{
    private function getWhatsappApiUrl()
    {
        $host = request()->getHost(); // ambil IP/domain Laravel saat ini
        return "http://{$host}:3000";
    }

    public static function isServerActive()
    {
        try {
            // Gunakan host dari request jika ada, fallback ke localhost
            $host = request()?->getHost();
            $host = $host ?: '127.0.0.1';

            $url = "http://{$host}:3000/status";

            $response = Http::timeout(3)->get($url);

            if ($response->successful()) {
                $status = strtolower($response->json('status') ?? '');
                return $status === 'connected';
            }

            return false;
        } catch (\Exception $e) {
            Log::warning('[WA Gateway] Tidak aktif: ' . $e->getMessage());
            return false;
        }
    }
    public static function sendMessage($sessionId, $number, $message)
    {
        // 🚨 sementara: jangan cek isServerActive()
        // if (!self::isServerActive()) { ... }

        $url = "http://127.0.0.1:3000/send-message";

        try {
            $response = Http::timeout(5)->post($url, [
                'id'      => $sessionId,
                'number'  => $number,
                'message' => $message
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'number'  => $number,
                'message' => 'Gagal mengirim: ' . $e->getMessage()
            ];
        }
    }

    public static function sendMessagex($sessionId, $number, $message)
    {
        // Cek apakah server WhatsApp WebJS aktif
        // if (!self::isServerActive()) {
        //     return [
        //         'status' => 'error',
        //         'message' => 'WhatsApp WebJS server tidak aktif.'
        //     ];
        // }

        // Ambil host dari request (agar fleksibel via IP)
        $host = request()->getHost();
        $url  = "http://{$host}:3000/send-message";

        // Siapkan array respons
        $responses = [];

        // Tangani multi atau single nomor
        $numbers = is_array($number) ? $number : [$number];

        foreach ($numbers as $singleNumber) {
            try {
                $response = Http::timeout(5)->post($url, [
                    'id'      => $sessionId,
                    'number'  => $singleNumber,
                    'message' => $message
                ]);

                $responses[] = $response->json();
            } catch (\Exception $e) {
                $responses[] = [
                    'status'  => 'error',
                    'number'  => $singleNumber,
                    'message' => 'Gagal mengirim: ' . $e->getMessage()
                ];
            }
        }
        sleep(rand(5, 10));
        // Kalau hanya 1 nomor, cukup kembalikan respons tunggal
        return is_array($number) ? $responses : $responses[0];
    }
    /*
        |--------------------------------------------------------------------------
        | 📌 SendMedia :
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - Mengirim Media
        | -
        |
        | Tujuan :
        | - Pengiriman media dan caption ke banyak no sekaligus, cocok digunakan pesan dengan timer
        |
        |
        | Penggunaan :
        | - $numbers = is_array($number) ? $number : [$number];
        | - Path File
        $filename = 'contoh.jpg';
        $filePath = base_path('whatsapp/uploads/' . $filename);

        */
    // Proses Coding ini menggunakan multer
    public static function sendMedia($sessionId, $number, $caption = '', $filePath)
    {
        // if (!self::isServerActive()) {
        //     return [
        //         'status' => 'error',
        //         'message' => 'WhatsApp WebJS server tidak aktif.'
        //     ];
        // }

        // $host = config('app.whatsapp_host', '127.0.0.1');
        // $url = "http://{$host}:3000/send-media";
        $url = "http://127.0.0.1:3000/send-media";

        $numbers = is_array($number) ? $number : [$number];
        $responses = [];

        foreach ($numbers as $singleNumber) {
            try {
                $response = Http::attach(
                    'media',
                    file_get_contents($filePath),
                    basename($filePath)
                )->post($url, [
                    'id' => $sessionId,
                    'number' => $singleNumber,
                    'caption' => $caption,
                ]);

                $responses[] = $response->json();
            } catch (\Exception $e) {
                $responses[] = [
                    'status' => 'error',
                    'number' => $singleNumber,
                    'message' => 'Gagal mengirim media: ' . $e->getMessage()
                ];
            }
            sleep(rand(2, 5));
        }
        sleep(rand(5, 10));
        return is_array($number) ? $responses : $responses[0];
    }

    public static function pdfToImageWa($namaFileJpg)
    {
        $basePath = base_path('whatsapp/uploads');
        $magickPath = '"C:\Program Files\ImageMagick-7.1.2-Q16-HDRI\magick.exe"';
        $pdfPath = base_path('Whatsapp/Uploads/' . $namaFileJpg . '.pdf');
        $outputPath = base_path('Whatsapp/Uploads/' . $namaFileJpg . '.jpg');

        // $command = "$magickPath -density 150 \"$pdfPath\"[0] -quality 100 \"$outputPath\"";
        $command = "$magickPath -density 300 \"$pdfPath\"[0] -background white -alpha remove -alpha off -quality 100 \"$outputPath\"";

        exec($command, $output, $returnVar);
        // Kembalikan nama file tanpa ekstensi agar bisa dipakai lanjut
        return $namaFileJpg;
    }
    /*
        |--------------------------------------------------------------------------
        | 📌 SendGroupMedia :
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
         $result = PesanWa::sendGroupMedia($request);

        if ($result['status']) {
            return redirect()->route('penjadwalan.index')->with('success', $result['message']);
        } else {
            return response()->json([
                'status' => false,
                'message' => $result['message']
            ], 500);
        }
        */
    // Proses Coding
    public static function sendGroupMedia(Request $request)
    {
        $sessionId = $request->input('sessionId', config('whatsappSession.IdWaUtama'));
        $receivers = $request->input('groupId');
        $caption = cleanPesanWA($request->input('caption'));

        $media = $request->file('media');

        if (!$media) {
            return [
                'status' => false,
                'message' => 'File tidak ditemukan.'
            ];
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
            }

            return [
                'status' => true,
                'message' => 'Pesanmu mantap!'
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Gagal kirim media: ' . $e->getMessage()
            ];
        }
    }
}
