<?php

namespace App\Models\WakaKesiswaan\Pengumuman;

use App\Models\Admin\Ekelas;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengumumanKelulusan extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
    ];

    protected $table = 'enilai_ujian_peserta';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    protected $dates = ['tanggal_pengumuman'];
    public function Siswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function kelas()
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
