<?php

namespace App\Models\WakaKurikulum\Elearning;

use App\Models\Admin\Emapel;
use Illuminate\Database\Eloquent\Model;

class KurikulumMateriAjar extends Model
{
    //
    protected $table = 'emateris';
    protected $fillable = [
            'field_one',
            'field_two',


        ];
        public function Mapel()
        {
           return $this->hasOne(Emapel::class, 'id', 'mapel_id');
        }
}
