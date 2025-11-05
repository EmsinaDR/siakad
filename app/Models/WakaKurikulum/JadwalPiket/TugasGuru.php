<?php

namespace App\Models\WakaKurikulum\JadwalPiket;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class TugasGuru extends Model
{
    //
    protected $table = 'etugas';
    protected $fillable = [
        'field_one',
        'field_two',



    ];
    public function Kelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Mapel()
    {
       return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }
}
