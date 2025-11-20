<?php

namespace App\Models\Program\Tagline;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class DataTagline extends Model
{
    //
    protected $table = 'data_tagline';
    protected $fillable = [
        'author',
        'judul',
        'isi',
        'is_aktif',
    ];
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'author');
    }
}
