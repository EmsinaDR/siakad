<?php

namespace App\Models\WakaKesiswaan\Ekstra;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;

class RiwayatEkstra extends Model
{
    //
    protected $table = 'ekstra_riwayat';
    protected $fillable = [
        'tapel_id',
        'detailguru_id',
        'pelatih',
        'jadwal',
        'ekstra_id',
        'peserta',
        'deskripsi',
    ];
        // riwayatekstr
    public function Ekstra()
    {
       return $this->hasOne(Ekstra::class, 'id', 'ekstra_id');
    }
    public function EkstraOne()
    {
       return $this->hasOne(Ekstra::class, 'id', 'ekstra_id');
    }

    public function Detailguru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Tapel()
    {
       return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }

}
