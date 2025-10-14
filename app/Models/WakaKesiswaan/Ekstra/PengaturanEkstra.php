<?php

namespace App\Models\WakaKesiswaan\Ekstra;

use Illuminate\Database\Eloquent\Model;

class PengaturanEkstra extends Model
{
    //
    protected $table = 'ekstra_pengaturan';
    protected $fillable = [
        'nama_pengaturan',
        'isi',
        'tapel_id',
        'ekstra_id',

        ];
}
