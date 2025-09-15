<?php

namespace App\Models\Program\PembinaOsis;

use App\Models\Admin\Ekelas;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnggotaOsis extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'tapel_id',
        'detailsiswa_id',
        'jabatan',
        'tahun_masuk',
        'keterangan',

    ];

    protected $table = 'anggota_osis';  // Misalkan model ini menggunakan nama tabel khusus

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
}
