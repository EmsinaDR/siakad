<?php

namespace App\Models\Program\VisiMisi;

use Illuminate\Database\Eloquent\Model;

class DataVisiMisi extends Model
{
    //
    protected $table = 'identitas';
    protected $fillable = [
        'visi',
        'misi',
        'tujuan',


    ];
}
