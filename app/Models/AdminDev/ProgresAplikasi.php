<?php

namespace App\Models\AdminDev;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresAplikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'judul',
        'role',
        'fitur',
        'model_class',
        'tanggal_mulai',
        'tanggal_akhir',
        'persentase',
        'keterangan',

    ];

    protected $table = 'progres_aplikasi';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
