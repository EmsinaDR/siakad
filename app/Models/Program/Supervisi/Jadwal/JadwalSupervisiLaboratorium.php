<?php

namespace App\Models\Program\Supervisi\Jadwal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSupervisiLaboratorium extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
'tanggal_pelaksanaan',
'tapel_id',
'petugas_id',
'petugas_id',
'laboratorium_id',
    ];

    protected $table = 'jadwal_supervisi_laboratorium';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
