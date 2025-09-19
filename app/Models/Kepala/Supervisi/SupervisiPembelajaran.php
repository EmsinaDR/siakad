<?php

namespace App\Models\Kepala\Supervisi;

use Illuminate\Database\Eloquent\Model;

class SupervisiPembelajaran extends Model
{
    //
    protected $table = 'supervisi_pembelajaran';
    protected $fillable = [
        'tapel_id',
        'keterangan',
        'semester',
        'detailguru_id',
        'indikator_id',
        'ketersediaan',
        'nilai',


        ];
}
