<?php

namespace App\Models\Laboratorium;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use Illuminate\Database\Eloquent\Model;

class PeraturanLaboratorium extends Model
{
    //
    protected $table = 'peraturan';
    protected $fillable = [
        'peraturan',
        'keterangan',
        'kategori',


    ];
}
