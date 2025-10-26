<?php

namespace App\Models\Laboratorium;

use Illuminate\Database\Eloquent\Model;
use App\Models\Laboratorium\Laboratorium;

class DashboardLaboratorium extends Model
{
    //
    protected $table = 'laboratorium_riwayat';
    protected $fillable = [
            'field_one',
            'field_two',


        ];
        public function Laboratorium()
        {
           return $this->hasOne(Laboratorium::class, 'id', 'laboratorium_id');
        }
}
