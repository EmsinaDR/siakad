<?php

namespace App\Models\WakaKurikulum\JadwalPiket;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class DataJadwalPiket extends Model
{
    //
    protected $table = 'jadwal_piket';
    protected $fillable = [
        'tapel_id',
        'detailguru_id',
        'hari',


    ];
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
