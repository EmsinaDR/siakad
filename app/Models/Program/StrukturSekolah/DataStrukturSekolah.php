<?php

namespace App\Models\Program\StrukturSekolah;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class DataStrukturSekolah extends Model
{
    //
    protected $table = 'struktur_organisasi';
    protected $fillable = [
        'tapel_id',
        'kategori',
        'detailguru_id',
        'parent_id',
        'jabatan',
        'created_at',
        'updated_at',


        ];
    public function guru()
    {
        return $this->belongsTo(Detailguru::class, 'detailguru_id');
    }
}
