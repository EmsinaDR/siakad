<?php

namespace App\Models\Program\PKKS;

use Illuminate\Database\Eloquent\Model;

class DataPKKS extends Model
{
    //
    protected $table = 'pkks_data';
    protected $fillable = [
        'system',
        'kategori',
        'indikator',
        'sub_indikator',
        'point',
        'nama_dokumen',
        'filename',
        'converter',


    ];
}
