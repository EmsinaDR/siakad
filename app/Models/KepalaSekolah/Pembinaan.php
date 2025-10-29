<?php

namespace App\Models\KepalaSekolah;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembinaan extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'tapel_id',
        'detailguru_id',
        'tanggal',
        'status',
        'indikator',
        'kesimpulan_umum',
        'tindak_lanjut',
        'keterangan',
    ];

    protected $table = 'pembinaan';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
