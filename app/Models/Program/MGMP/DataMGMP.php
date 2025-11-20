<?php

namespace App\Models\Program\MGMP;

use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class DataMGMP extends Model
{
    //
    protected $table = 'data_mgmp';
    protected $fillable = [
        'tapel_id',
        'mapel_id',
        'detailguru_id',

    ];
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Mapel()
    {
       return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }
}
