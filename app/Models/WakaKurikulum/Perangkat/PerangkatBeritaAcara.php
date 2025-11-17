<?php

namespace App\Models\WakaKurikulum\Perangkat;

use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class PerangkatBeritaAcara extends Model
{
    //
    protected $table = 'test_jadwal';

    protected $fillable = [
        'tapel_id',
        'semester',
        'tanggal_pelaksanaan',
        'durasi',
        'mapel_id',
        'ruang_test',
        'detailguru_id',
        'detailsiswa_id',
    ];
    public function Tapel()
    {
        return $this->belongsTo(Etapel::class);
    }

    public function Mapel()
    {
        return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }

    // public function Guru()
    // {
    //     return $this->belongsTo(Detailguru::class);
    // }
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
