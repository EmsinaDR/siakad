<?php

namespace App\Models\Program\Supervisi;

use App\Models\Admin\Etapel;
use Illuminate\Database\Eloquent\Model;

class SupervisiPerpustakaan extends Model
{
    //
    protected $table = 'supervisi_perpustakaan';
    protected $fillable = [
        'tapel_id',
        'semester',
        'detailguru_id',
        'indikator_id',
        'ketersediaan',
        'nilai',
        'keterangan',
        'analisis',

    ];
    public function Guru()
    {
        return $this->hasOne(SupervisiPerpustakaan::class, 'id', 'detailguru_id');
    }
    public function Tapel()
    {
       return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
}
