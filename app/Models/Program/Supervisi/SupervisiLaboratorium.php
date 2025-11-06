<?php

namespace App\Models\Program\Supervisi;

use Illuminate\Database\Eloquent\Model;

class SupervisiLaboratorium extends Model
{
    //
    protected $table = 'supervisi_laboratorium';
    protected $fillable = [
        'tapel_id',
        'semester',
        'laboratorium_id',
        'indikator_id',
        'ketersediaan',
        'nilai',
        'keterangan',
        'analisis',

    ];
}
