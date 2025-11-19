<?php

namespace App\Models\Bendahara\PIP;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranBendaharaPip extends Model
{
    use HasFactory;
    protected $fillable = [
        'tapel_id',
        'detailsiswa_id',
        'detailguru_id',
        'tanggal_pengeluaran',
        'pengeluaran',
        'tujuan_penggunaan',
        'keterangan',
        'is_transfer',
        'nominal',
    ];

    protected $table = 'pengeluaran_pip';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan

    public function Tapel()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Siswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
}
