<?php

namespace App\Models\WakaKesiswaan\Ekstra;

use Illuminate\Database\Eloquent\Model;

class JurnalEkstra extends Model
{
    //
    protected $table = 'ekstra_jurnal';
    protected $fillable = [
        'ekstra_id',
        // 'materi',
        // 'sub_materi',
        'indikator_id',
        'tapel_id',
        'semester',
        'tanggal_latihan',
    ];
    public function MateriEkstra()
    {
       return $this->hasOne(MateriEkstra::class, 'id', 'indikator_id');
    }

}
