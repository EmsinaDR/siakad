<?php

namespace App\Models\Program\PKKS;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class ProgresPKKS extends Model
{
    //
    protected $table = 'pkks_progres';
    protected $fillable = [
        'tapel_is',
        'data_id',
        'detailguru_id',
        'progres',
        'upload_dokumen',
        'link',
    ];
    public function Indikator()
    {
        return $this->hasOne(DataPKKS::class, 'id', 'data_id');
    }
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
