<?php

namespace App\Models\WakaKurikulum\Perangkat;

use App\Models\Admin\Ekelas;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class PerangkatTempatDuduk extends Model
{
    //
    protected $table = 'test_peserta';
    protected $fillable = [
        'tapel_id',
        'semester',
        'kelas_id',
        'tingkat_id',
        'detailsiswa_id',
        'nomor_ruangan',
        'nomor_test',
        'nomor_urut',


    ];
    public function PesertaTestToDetailSiswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function PesertaTestToKelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function Kelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function Siswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
}
