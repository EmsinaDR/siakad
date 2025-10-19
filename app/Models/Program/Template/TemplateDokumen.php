<?php

namespace App\Models\Program\Template;

use Illuminate\Database\Eloquent\Model;

class TemplateDokumen extends Model
{
    //
    protected $table = 'template_dokumen';
    protected $fillable = [
        'nama_dokumen',
        'content',
        'kategori',
        'name_input',


    ];
}
