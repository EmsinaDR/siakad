<?php

namespace App\Models\Learning;

use Exception;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\User\Siswa\Detailsiswa;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EnilaiTugas extends Model
{
    //
    protected $table = 'enilai_tugas';
    public function EnilaitugastoDetailgurus(): HasOne
    {
        // return this->hasOne(Detailguru::class);
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function EnilaitugastoDetailSiswas(): HasOne
    {
        // return this->hasOne(DetailSiswa::class);
        return $this->hasOne(DetailSiswa::class, 'id', 'detailsiswa_id');
    }
    public function EnilaitugastoEmapels(): HasOne
    {
        // return this->hasOne(Emapel::class);
        return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }
    // public function EnilaitugastoEtingkatss(): HasOne
    // {
    //     // return this->hasOne(Detailguru::class);
    //     return $this->hasOne(Etingkats::class, 'id', 'etingkat_id');
    // }
    public function EnilaitugastoEkelass(): HasOne
    {
        // return this->hasOne(Ekelas::class);
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
