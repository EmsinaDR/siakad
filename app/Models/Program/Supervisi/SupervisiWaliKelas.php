<?php

namespace App\Models\Program\Supervisi;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class SupervisiWaliKelas extends Model
{
    //
    protected $table = 'supervisi_wali_kelas';
    protected $fillable = [
        'tapel_id',
        'semester',
        'kelas_id',
        'indikator_id',
        'ketersediaan',
        'nilai',
        'keterangan',
        'analisis',

    ];
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
