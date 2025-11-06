<?php

namespace App\Models\Paket\Kerjasama;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuAdm extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
    ];

    protected $table = 'perpustakaan_ebook';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
