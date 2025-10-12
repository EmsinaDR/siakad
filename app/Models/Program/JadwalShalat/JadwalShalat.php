<?php

namespace App\Models\Program\JadwalShalat;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class JadwalShalat extends Model
{
    //
    protected $table = 'shalat_berjamaah_jadwal';
    protected $fillable = [
        'field_one',
        'field_two',


    ];
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'imam');
    }
}
