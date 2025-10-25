<?php

namespace App\Models\WakaKurikulum\Kelulusan;

use App\Models\Admin\Ekelas;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class PesertaKelulusan extends Model
{
    //
    protected $table = 'enilai_ujian_peserta';
    protected $fillable = [
        'status_kelulusan',
        'tahun_lulus',
        'detailsiswa_id',


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
