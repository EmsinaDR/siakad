<?php

namespace App\Models\Whatsapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppSession extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_session_name';

    protected $fillable = [
        'no_hp',
        'nama_akun',
        'akun_id',
        'tingkat_id',
        'tujuan',
        'keterangan',
    ];
}
