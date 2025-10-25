<?php

namespace App\Models\Perpustakaan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ebook extends Model
{
    //
    use HasFactory;
    protected $table = 'perpustakaan_ebook';

    protected $fillable = [
        'judul_ebook',
        'kode_buku',
        'isbn',
        'kategori_id',
        'judul_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'tahun_masuk',
        'link_ebook',
        'abstraksi',
    ];

    public function EbookToKategori()
    {
        return $this->hasOne(PerpustakaanKategoriBuku::class, 'id', 'kategori_id');
    }
    public function kategori()
    {
        return $this->belongsTo(PerpustakaanKategoriBuku::class, 'kategori_id');
    }
}
