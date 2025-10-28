<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Model;

class InventarisVendor extends Model
{
    //
    protected $table = 'inventaris_vendor';
    protected $fillable = [
        'nama_vendor',
        'nama_kontak',
        'nomor_hp',
        'alamat',
        'keterangan',

    ];
}
