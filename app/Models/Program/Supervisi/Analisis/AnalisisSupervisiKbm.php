<?php

namespace App\Models\Program\Supervisi\Analisis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisSupervisiKbm extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
    ];

    protected $table = 'analisis_supervisi_kbm';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
