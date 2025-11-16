<?php

namespace App\Models\Program\Supervisi;

use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program\Supervisi\SupervisiInstrument;

class SupervisiATP extends Model
{
    //
    protected $table = 'supervisi_pembelajaran';
    protected $fillable = [
        'tapel_id',
        'semester',
        'kelas_id',
        'mapel_id',
        'detailguru_id',
        'indikator_id',
        'ketersediaan',
        'nilai',
        'keterangan',
        'analisis',


    ];
    public function Indkator()
    {
        return $this->hasOne(SupervisiInstrument::class, 'id', 'indikator_id');
    }
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Mapel()
    {
        return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }
}
