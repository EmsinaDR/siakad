<?php

namespace App\Http\Controllers\Whatsapp;

use Illuminate\Http\Request;
use App\Models\Whatsapp\WhatsAppSession;
use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Process\Exception\ProcessFailedException;

class WhatsappSessionController extends Controller
{
    protected $sessionPath = 'wa-sessions';

    public function storeKoneksi(Request $request)
    {
        $request->validate([
            'session_name' => 'required|string',
            'session_data' => 'required|array',
        ]);

        $fileName = $this->sessionPath . '/' . $request->session_name . '.json';

        Storage::put($fileName, json_encode($request->session_data));

        return response()->json([
            'success' => true,
            'message' => "Session '{$request->session_name}' berhasil disimpan.",
        ]);
    }
    // Aktikan server
    public function runServer(Request $request)
    {
        $batFile = base_path('whatsapp/aktifkanx.bat');


        $batFile = base_path('executor/whatsapp/serverjs.exe');
        pclose(popen("start \"\" \"$batFile\"", "r"));

        return response()->json([
            'message' => 'server.js sedang dijalankan dari .bat!',
        ]);
    }
    public function restartServer(Request $request)
    {
        // $batFile = base_path('whatsapp/restart_services.bat');


        // $batFile = base_path('whatsapp/restart_services.bat');
        $batFile = base_path('executor/whatsapp/restart_services.exe');
        pclose(popen("start \"\" \"$batFile\"", "r"));

        return response()->json([
            'message' => 'server.js sedang dijalankan dari .bat!',
        ]);
    }
    // Hapus Folder Sesi
    public function hapusSession(Request $request)
    {
        $session = $request->input('session_id');
        if (!$session) {
            return response()->json(['message' => '❌ Session ID tidak ditemukan.'], 400);
        }

        $folder = base_path("whatsapp/.wwebjs_auth/session-$session");
        // dd($folder);

        if (!is_dir($folder)) {
            return response()->json(['message' => "⚠️ Folder sesi 'session-$session' $folder tidak ditemukan."]);
        }

        $command = "rmdir /s /q \"$folder\"";
        $process = Process::fromShellCommandline($command);
        $process->run();

        if ($process->isSuccessful()) {
            return response()->json(['message' => "✅ Session '$session' berhasil dihapus."]);
        } else {
            return response()->json([
                'message' => '❌ Gagal menghapus sesi.',
                'error' => $process->getErrorOutput()
            ], 500);
        }
    }

    public function AkaunBaru(Request $request)
    {
        // Hapus spasi, strip, titik
        $no_hp = preg_replace('/[\s\.\-]/', '', $request->no_hp);

        // Ganti awalan 0 jadi 62
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }

        // Ganti awalan +62 jadi 62
        if (substr($no_hp, 0, 3) === '+62') {
            $no_hp = '62' . substr($no_hp, 3);
        }
        $request->merge([
            'akun_id' => str_replace(' ', '', strtolower($request->nama_akun)),
            'no_hp' => $no_hp,
        ]);
        // dd($request->all());
        $request->validate([
            'no_hp'       => 'nullable|string|max:20',
            'nama_akun'   => 'nullable|string|max:100',
            'akun_id'     => 'nullable|string|max:100',
            'tujuan'      => 'nullable|string|max:255',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        // Simpan ke database dengan mass assignment
        $data = WhatsAppSession::create($request->only([
            'no_hp',
            'nama_akun',
            'akun_id',
            'tujuan',
            'keterangan',
        ]));
        HapusCacheDenganTag('cache_DataSessionNames');

        return Redirect::back()->with('Title', 'Sukses')->with('Success', 'Data berhasil disimpan');
    }

    public function update(Request $request)
    {
        $request->validate([
            'session_name' => 'required|string',
            'updated_data' => 'required|array',
        ]);

        $fileName = $this->sessionPath . '/' . $request->session_name . '.json';

        if (!Storage::exists($fileName)) {
            return response()->json([
                'success' => false,
                'message' => "Session '{$request->session_name}' tidak ditemukan.",
            ], 404);
        }

        $existing = json_decode(Storage::get($fileName), true);
        $merged = array_merge($existing, $request->updated_data);

        Storage::put($fileName, json_encode($merged));

        return response()->json([
            'success' => true,
            'message' => "Session '{$request->session_name}' berhasil diperbarui.",
        ]);
    }

    public function load($sessionName)
    {
        $fileName = $this->sessionPath . '/' . $sessionName . '.json';

        if (!Storage::exists($fileName)) {
            return response()->json([
                'success' => false,
                'message' => "Session '{$sessionName}' tidak ditemukan.",
            ], 404);
        }

        $data = json_decode(Storage::get($fileName), true);

        return response()->json([
            'success' => true,
            'session' => $data,
        ]);
    }
}
