<?php

namespace App\Models\Program\Supervisi;

use Illuminate\Database\Eloquent\Model;

class SupervisiInstrument extends Model
{
    //supervisi_instrument
    protected $table = 'supervisi_instrument';
    protected $fillable = [
        'bidang',
        'kategori',
        'sub_kategori',
        'indikator',
    ];
}
