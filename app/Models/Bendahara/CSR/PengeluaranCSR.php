<?php

namespace App\Models\Bendahara\CSR;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranCSR extends Model
{
    use HasFactory;

    protected $fillable = [
        'tapel_id',
        'semester',
        'petugas_id',
        'jenis_pengeluaran',
        'nominal',
        'keterangan',
        'tanggal',
        'csr_id',
    ];

    protected $table = 'keuangan_pengeluaran_csr';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'petugas_id');
    }
    public function Tapel()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
    public function DanaCsr()
    {
        return $this->hasOne(PemasukkanCSR::class, 'id', 'csr_id');
    }
}
