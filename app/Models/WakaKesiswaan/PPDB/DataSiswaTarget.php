<?php

namespace App\Models\WakaKesiswaan\PPDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSiswaTarget extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'nama_siswa',
        'no_hp',
        'asal_sd',
        'keterangan'
    ];

    protected $table = 'data_siswa_target';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
