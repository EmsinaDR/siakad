<?php

namespace App\Models\Paket\Kerjasama;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKerjasama extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
    ];

    protected $table = 'data_kerjasama';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
