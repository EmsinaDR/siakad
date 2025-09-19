<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class pengaturan extends Model
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
