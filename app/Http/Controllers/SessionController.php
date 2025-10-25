<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SessionController extends Controller
{
    private $serverUrl = 'http://localhost:3000'; // Sesuaikan jika port berbeda

    public function startSession(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string'
        ]);

        $response = Http::post("$this->serverUrl/start-session", [
            'sessionId' => $request->session_id,
        ]);

        return response()->json($response->json());
    }
}
