<?php

namespace App\Models\WakaKurikulum\Perangkat;

use Illuminate\Database\Eloquent\Model;

class PeraturanTest extends Model
{
    //
    protected $table = 'peraturan';
    protected $fillable = [
        'kategori',
        'sub_kategori',
        'peraturan',
        'keterangan',
    ];
}
