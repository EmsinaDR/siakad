<?php

namespace App\Models\Program\Tupoksi;

use Illuminate\Database\Eloquent\Model;

class DataTupoksi extends Model
{
    //
    protected $table = 'data_tupoksi';
    protected $fillable = [
        'tapel_id',
        'bidang',
        'isi',


    ];
}
