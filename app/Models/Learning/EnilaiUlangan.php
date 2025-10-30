<?php

namespace App\Models\Learning;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EnilaiUlangan extends Model
{
    //
    public function EnilaiulangantoDetailgurus(): HasOne
    {
        // return this->hasOne(Detailguru::class);
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function EnilaiulangantoDetailSiswas(): HasOne
    {
        // return this->hasOne(DetailSiswa::class);
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');;
    }
    public function EnilaiulangantoEmapels(): HasOne
    {
        // return this->hasOne(Emapel::class);
        return $this->hasOne(Emapel::class, 'id', 'mapel_id');;
    }
    // public function EnilaiulangantoEtingkatss(): HasOne
    // {
    //     // return this->hasOne(Detailguru::class);
    //     return $this->hasOne(Etingkats::class, 'id', 'etingkat_id');
    // }
    public function EnilaiulangantoEkelass(): HasOne
    {
        // return this->hasOne(Ekelas::class);
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');;
    }
}
