<?php

namespace App\Models\Program\CBT;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class CBTJadwal extends Model
{
    //
    protected $table = 'jadwal_cbt';
    protected $fillable = [
        'field_one',
        'field_two',


    ];
    protected $casts = [
        'soal_id' => 'array',
    ];
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Mapel()
    {
       return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }
    public function Kelas()
    {
       return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
