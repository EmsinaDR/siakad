<?php

namespace App\Models\Program\Supervisi\Jadwal;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSupervisiWaka extends Model
{
    use HasFactory;

    protected $fillable = [
        'tapel_id',
        'kategori',
        'detailguru_id',
        'tanggal_pelaksanaan',
        'keterangan',
    ];

    protected $table = 'jadwal_supervisi_waka';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Tapel()
    {
       return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
}
