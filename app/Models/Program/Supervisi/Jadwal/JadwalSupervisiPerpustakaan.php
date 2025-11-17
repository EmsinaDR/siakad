<?php

namespace App\Models\Program\Supervisi\Jadwal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSupervisiPerpustakaan extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'tapel_id',
        'petugas_id',
        'tanggal_pelaksanaan',
        'keterangan',
    ];

    protected $table = 'jadwal_supervisi_perpustakaan';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
