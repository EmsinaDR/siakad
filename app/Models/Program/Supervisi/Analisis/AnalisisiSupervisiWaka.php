<?php

namespace App\Models\Program\Supervisi\Analisis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisiSupervisiWaka extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
    ];

    // protected $table = 'analisisi_supervisi_waka';  // Misalkan model ini menggunakan nama tabel khusus
    protected $table = 'supervisi_waka';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
