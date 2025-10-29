<?php

namespace App\Models\WakaKesiswaan\PPDB;

use Illuminate\Database\Eloquent\Model;

class PengaturanPPDB extends Model
{
    //
    protected $table = 'pengaturan';
    protected $fillable = [
        'tapel_id',
        'tentang',
        'isi',
        'keterangan',
    ];
    protected $casts = [
        'isi' => 'array', // Laravel otomatis mengubah JSON ke array
    ];
}
