<?php

namespace App\Models\Program\Supervisi\Waka;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class SupervisiWakaSarpras extends Model
{
    //
    protected $table = 'supervisi_waka';
    protected $fillable = [
        'tapel_id',
        'semester',
        'laboratorium_id',
        'indikator_id',
        'ketersediaan',
        'nilai',
        'keterangan',
        'analisis',
        'bidang',
        'detailguru_id',

    ];
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Tapel()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
}
