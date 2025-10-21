<?php

namespace App\Models\Program\Supervisi\Jadwal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSupervisiGuru extends Model
{
    use HasFactory;

    protected $fillable = [
        'tapel_id',
        'semester',
        'kategori',
        'detailguru_id',
        'mapel_id',
        'tanggal_pelaksanaan',
        'Keterangan',
        'kelas_id',
    ];

    protected $table = 'jadwal_supervisi_guru';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
