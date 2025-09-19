<?php

namespace App\Models\Bendahara\CSR;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemasukkanCSR extends Model
{
    use HasFactory;

    protected $fillable = [
        'petugas_id',
        'tapel_id',
        'nama_corporate',
        'sumber_dana',
        'bentuk_bantuan',
        'nominal',
        'tujuan_bantuan',
        'keterangan',
        'status',
        'tanggal_bantuan',
    ];
    protected $table = 'keuangan_pemasukkan_csr';  // Misalkan model ini menggunakan nama tabel khusus

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
}
