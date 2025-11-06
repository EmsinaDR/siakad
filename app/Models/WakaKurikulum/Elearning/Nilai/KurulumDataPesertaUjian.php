<?php

namespace App\Models\WakaKurikulum\Elearning\Nilai;

use App\Models\Admin\Ekelas;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class KurulumDataPesertaUjian extends Model
{
    //
    protected $table = 'enilai_ujian_peserta';
    protected $fillable = [
        'tapel_id',
        'nomor_ujian',
        'nomor_ruangan',
        'kelas_id',
        'detailsiswa_id',
        'tahun_lulus',
        'status_kelulusan',
        'tanggal_pengumuman',
    ];
    public function Siswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function Kelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
