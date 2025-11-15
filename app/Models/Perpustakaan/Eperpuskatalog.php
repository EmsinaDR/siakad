<?php

namespace App\Models\Perpustakaan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eperpuskatalog extends Model
{
    use HasFactory;
    // protected $table = 'keuangan_komite';
    protected $table = 'perpustakaan_katalog_buku';
    protected $fillable = [
        'kode_buku',
        'kategori_id',
        'judul_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'nomor_rak',
        'isbn',
        'jumlah',
        'keterangan',
        'harga',
        'tahun_masuk',
        'baik',
        'rusak',
        'sumber_dana',
    ];


    public function EperpuskatalogToPerpustakaanKategoriBuku()
    {
        return $this->hasOne(PerpustakaanKategoriBuku::class, 'id', 'kategori_id');
    }
    public function Kategori()
    {
        return $this->belongsTo(PerpustakaanKategoriBuku::class, 'kategori_id');
    }
}
