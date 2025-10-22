<?php

namespace App\Models\Laboratorium;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use App\Models\Laboratorium\Elaboratorium;

class RiwayatLaboratorium extends Model
{
    protected $table = 'laboratorium_riwayat';
    protected $fillable = [
        'tapel_id',
        'kode_ruangan',
        'ruang_id',
        'laboratorium_id',
        'aktiv',
        'detailguru_id',
    ];


    public function LaboratoriumOne()
    {
        return $this->hasOne(Elaboratorium::class, 'id', 'laboratorium_id');
    }
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function elaboratorium()
    {
        return $this->hasOne(Elaboratorium::class, 'id', 'laboratorium_id');
    }
}
