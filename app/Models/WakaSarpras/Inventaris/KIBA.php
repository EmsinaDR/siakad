<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Model;
use App\Models\WakaSarpras\Inventaris\Inventaris;

class KIBA extends Model
{
    //
protected $table = 'inventaris_kiba';
    protected $fillable = [
        'barang_id',
        'nama_barang',
        'letak',
        'luas',
        'tahun_masuk',
        'status_hak',
        'penggunaan'
    ];
    public function DataBarang()
    {
       return $this->hasOne(Inventaris::class, 'id', 'barang_id');
    }
}
