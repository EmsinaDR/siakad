<?php

namespace App\Models\Bendahara;

use App\Models\Admin\Etapel;
use Illuminate\Database\Eloquent\Model;

class RiwayatStudyTour extends Model
{
    //
    protected $table = 'study_tour_riwayat';
    public function RiwayatStudyTourToTapel()
    {
       return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
}
