<?php

namespace App\Models\WakaKesiswaan\Ekstra;

use Illuminate\Database\Eloquent\Model;

class MateriEkstra extends Model
{
    //
    protected $table = 'ekstra_materi';

    protected $fillable = [
        'ekstra_id',
        'materi',
        'sub_materi',
        'indikator',
    ];
}
