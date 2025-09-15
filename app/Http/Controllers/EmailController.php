<?php

namespace App\Http\Controllers;

use App\Mail\KirimEmail; // <-- Ini Mailablenya
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    // public function kirim()
    // {
    //     $data = [
    //         'nama' => 'Bro',
    //         'pesan' => 'Selamat! Ini email dari Laravel.',
    //     ];

    //     Mail::to('target@email.com')->send(new KirimEmail($data));

    //     return 'Email berhasil dikirim!';
    // }
    public function kirim(Request $request)
    {
        $to = $request->to;
        $subject = $request->subject;
        $messageBody = $request->message;

        Mail::raw($messageBody, function ($message) use ($to, $subject) {
            $message->to($to)
                ->subject($subject);
        });

        return back()->with('success', 'Email berhasil dikirim!');
    }
}
