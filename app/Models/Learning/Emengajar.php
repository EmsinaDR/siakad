<?php

namespace App\Models\Learning;

// namespace App\Models\Inventaris;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Emengajar extends Model
{
    use HasFactory;

    public function emengajartomapel()
    {
        return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }
    public function emengajartokelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function emengajartoDetailgurus(): HasOne
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Mapel()
    {
        return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }
    public function Kelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function Guru(): HasOne
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }


    public function bmapel()
    {
        return $this->belongsTo(Emapel::class, 'mapel_id');
    }

    public function bkelas()
    {
        return $this->belongsTo(Ekelas::class, 'kelas_id');
    }

    public function bguru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }


}
