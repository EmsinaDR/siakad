<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Model;

class KIBB extends Model
{

    protected $table = 'inventaris_kibb';
    protected $fillable = [
        'barang_id',
        'kode_barang',
        'nama_barang',
        'vendor_id',
        'merek',
        'tahun_masuk',
        'kondisi',
        'spesifikasi',
        'jumlah',
        'harga',
        'lokasi',
        'keterangan'
        ];
    public function InventarisVendor()
    {
       return $this->hasOne(InventarisVendor::class, 'id', 'vendor_id');
    }
    public function Barang()
    {
       return $this->hasOne(Inventaris::class, 'id', 'barang_id');
    }
}
