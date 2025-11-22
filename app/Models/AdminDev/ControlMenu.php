<?php

namespace App\Models\AdminDev;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'detailguru_id',
        'aktivasi',
        'pilihan',

        // Tentukan field yang bisa diisi
    ];

    protected $table = 'program';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
