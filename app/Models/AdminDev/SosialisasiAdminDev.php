<?php

namespace App\Models\AdminDev;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SosialisasiAdminDev extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'judul',
        'kategori',
        'aplikasi',
        'pesan',
        'target',
        'jam',
        'tanggal',
        'keterangan',
        'jumlah_terkirim',
        ''
    ];

    protected $table = 'sosialisasi_admin_dev';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
