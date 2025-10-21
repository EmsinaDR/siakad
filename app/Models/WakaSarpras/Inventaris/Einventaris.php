<?php

namespace App\Models\WakaSarpras\Inventaris;

use App\Models\WakaKesiswaan\Inventaris\InventarisKategori;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Einventaris extends Model
{
    use HasFactory;
    protected $table = 'inventaris';
    protected $fillable = [
        'kode',
        'system',
        'nama_barang',
        'kategori_id',
        'keterangan',

        ];
        // public function Kategori()
        // {
        //    return $this->hasOne(InventarisKategori::class, 'id', 'kategori_id');
        // }
}
