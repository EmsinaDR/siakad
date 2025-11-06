<?php

namespace App\Models\Program\Supervisi;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use Illuminate\Database\Eloquent\Model;

class SupervisiPembelajaran extends Model
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
        public function Mapel()
        {
           return $this->hasOne(Emapel::class, 'id', 'mapel_id');
        }
        public function Kelas()
        {
           return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
        }
}
