<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Model;

class KIBC extends Model
{
    //
    protected $table = 'inventaris_kibc';
    protected $fillable = [
        'inventaris_id',
        'kode_ruangan',
        'nama_ruangan',
        'kondisi',
        'panjang',
        'lebar',
        'spesifikasi',
        'keterangan',
    ];
    public function Barang()
    {
        return $this->hasOne(Inventaris::class, 'id', 'inventaris_id');
    }
}
