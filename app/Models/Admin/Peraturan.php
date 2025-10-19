<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Peraturan extends Model
{
    //
    protected $table = 'peraturan';
    protected $fillable = [
        'kategori',
        'sub_kategori',
        'peraturan',
        'keterangan',
        ];
}
