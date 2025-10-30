<?php

namespace App\Models\Tools\KirikdanSaran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KritikSaran extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'detailsiswa_id',
        'detailguru_id',
        'nohp',
        'bidang',
        'kritik',
        'saran'
    ];

    protected $table = 'kritik_saran';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
