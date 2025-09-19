<?php

namespace App\Models\Bendahara\DaftarUlang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianDaftarUlang extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
    ];

    protected $table = 'keuangan_rincian_du';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
