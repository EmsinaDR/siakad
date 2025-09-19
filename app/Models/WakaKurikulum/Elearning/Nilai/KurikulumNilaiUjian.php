<?php

namespace App\Models\WakaKurikulum\Elearning\Nilai;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KurikulumNilaiUjian extends Model
{
    //
    protected $table = 'enilai_ujian';
    protected $fillable = [
        'tapel_id',
        'nomor_ujian',
        'nomor_ruangan',
        'mapel_id',
        'kelas_id',
        'detailsiswa_id',
        'nilai'


        ];
    public function Guru(): HasOne
    {
        // return this->hasOne(Detailguru::class);
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Siswa(): HasOne
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function Mapel(): HasOne
    {
        return $this->hasOne(Emapel::class, 'id', 'mapel_id');;
    }
    public function Kelas(): HasOne
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function Peserta()
    {
       return $this->hasOne(WakaKurulumDataPesertaUjian::class, 'id', 'peserta_id');
    }
}
