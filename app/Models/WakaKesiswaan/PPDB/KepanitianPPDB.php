<?php

namespace App\Models\WakaKesiswaan\PPDB;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class KepanitianPPDB extends Model
{
    //
    protected $table = 'ppdb_panitia';
    protected $fillable = [
        'detailguru_id',
        'jabatan',
        'tapel_id',


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
