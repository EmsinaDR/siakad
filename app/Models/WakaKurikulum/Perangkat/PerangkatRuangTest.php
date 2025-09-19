<?php

namespace App\Models\WakaKurikulum\Perangkat;

use Illuminate\Database\Eloquent\Model;

class PerangkatRuangTest extends Model
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
}
