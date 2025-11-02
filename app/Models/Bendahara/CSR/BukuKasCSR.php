<?php

namespace App\Models\Bendahara\CSR;

use App\Models\Admin\Etapel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuKasCSR extends Model
{
    use HasFactory;

    protected $fillable = [
        'tapel_id',
        'petugas_id',
        'tanggal',
        'uraian',
        'pemasukan_id',
        'pengeluaran_id',
        'penerimaan',
        'pengeluaran',
        'keterangan',
    ];

    protected $table = 'kas_csr';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Tapel()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
    public function DanaPengeluaran()
    {
        return $this->hasOneThrough(
            PemasukkanCSR::class,        // Model tujuan akhir
            PengeluaranCSR::class,  // Model perantara
            'id',                // FK di Detailsiswa yang mengarah ke Kelas (kelas_id)
            'id',                // FK di Kelas
            'pengeluaran_id',     // FK di PesertaTahfidz yang mengarah ke Detailsiswa
            'csr_id'           // FK di Detailsiswa yang mengarah ke Kelas
        );
    }
    public function DanaPemasukkan()
    {
        return $this->belongsTo(PemasukkanCSR::class, 'pemasukkan_id', 'id');
    }
    public function Xdana()
    {
       return $this->hasOne(PemasukkanCSR::class, 'id', 'pemasukkan_id');
    }
}
