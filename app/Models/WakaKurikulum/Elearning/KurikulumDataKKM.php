<?php

namespace App\Models\WakaKurikulum\Elearning;

use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class KurikulumDataKKM extends Model
{
    //
    protected $table = 'data_kkm';
    protected $fillable = [
        'field_one',
        'field_two',


    ];
    // public function Mapel()
    // {
    //     return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    // }
    // public function mapel()
    // {
    //     return $this->hasOne(Emapel::class, 'id', 'mapel_id'); // Pastikan 'id' adalah primary key
    // }
    public function mapel()
    {
        return $this->belongsTo(Emapel::class, 'mapel_id', 'id');
    }
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
