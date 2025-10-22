<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    //
    protected $table = 'tingkats';
    protected $fillable = [
        'tingkat',
        'jengjang',
        'tingkat_nama',
        'tingkat_urutan'


    ];
}
