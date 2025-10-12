<?php

namespace App\Models\Whatsapp;

use Illuminate\Database\Eloquent\Model;

class WhatsappLog extends Model
{
    //
    protected $table = 'whatsapp_log';
    protected $fillable = [
        'nomor_target',
        'isi_pesan',
        'balasan',
        'tanggal',
    ];

    // Jika mau, bisa juga tambah casting tanggal biar otomatis jadi Carbon
    protected $casts = [
        'tanggal' => 'date',
    ];
    public static function LogWhatsapp($NoRequest, $Pesan)
    {
        //dd($request->all());
        WhatsappLog::create([
            'nomor_target' => $NoRequest,
            'isi_pesan' => $Pesan,
            'balasan' => 'Sesuai Format',
            // 'tanggal' => now()->toDateString(),
        ]);
        return 'ok';
    }
}
