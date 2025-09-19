<?php

namespace App\Models\Perpustakaan;

use Illuminate\Database\Eloquent\Model;
use App\Models\Perpustakaan\Eperpuskatalog;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerpustakaanKategoriBuku extends Model
{
    //
    // use HasFactory;
    protected $table = 'perpustakaan_kategori_buku';


    protected $fillable = [
        'kode',
        'nama_kategori',
        'keterangan',
    ];

    public function buku()
    {
        return $this->hasMany(Eperpuskatalog::class, 'kategori_id');
    }
}
