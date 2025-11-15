<?php

namespace App\Models\Absensi;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EabsenGuru extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'tapel_id',
        'ijin_id',
        'detailguru_id',
        'waktu_absen',
        'whatsapp_respon',
        'jenis_absen',
        'telat',
        'semester',
        'absen',
        'keterangan'
    ];

    protected $table = 'eabsens_guru';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function guru()
    {
        return $this->belongsTo(Detailguru::class, 'detailguru_id');
    }
}
