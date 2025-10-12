<?php

namespace App\Models\Laboratorium;

use Illuminate\Database\Eloquent\Model;
use App\Models\WakaKesiswaan\Inventaris\Inventaris;
use App\Models\Laboratorium\InventarisKategoriRuang;
use App\Models\WakaKesiswaan\Inventaris\InventarisKategori;

class InventarisLaboratorium extends Model
{
    //
    protected $table = 'inventaris_in_ruangan';
    protected $fillable = [
        'field_one',
        'field_two',


    ];
    public function Ruang()
    {
        return $this->hasOne(InventarisKategoriRuang::class, 'id', 'ruang_id');
    }
    public function Barang()
    {
        return $this->hasOne(Inventaris::class, 'id', 'inventaris_id');
    }
    public function Kategori()
    {
        return $this->hasOneThrough(
            InventarisKategori::class,  // Model yang dituju (Kategori)
            Inventaris::class,          // Model perantara (Inventaris)
            'id',                       // Primary key di tabel Inventaris
            'id',                       // Primary key di tabel Kategori
            'inventaris_id',            // Foreign key di tabel Barang
            'kategori_id'               // Foreign key di tabel Inventaris
        );
    }
}
// InventarisKategoriRuang
