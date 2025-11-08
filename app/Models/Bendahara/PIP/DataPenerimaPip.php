<?php

namespace App\Models\Bendahara\PIP;

use App\Models\Admin\Ekelas;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPenerimaPip extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'detailsiswa_id',
        'detailguru_id',
    ];

    protected $table = 'data_penerima_pip';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Siswa()
    {
       return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }

    public function Kelas()
        {
            return $this->hasOneThrough(
                Ekelas::class,        // Model tujuan akhir
                Detailsiswa::class,  // Model perantara
                'id',                // FK di Detailsiswa yang mengarah ke Kelas (kelas_id)
                'id',                // FK di Kelas
                'detailsiswa_id',     // FK di PesertaTahfidz yang mengarah ke Detailsiswa
                'kelas_id'           // FK di Detailsiswa yang mengarah ke Kelas
            );
        }
    public function Petugas()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
