<?php

namespace App\Models\WakaKesiswaan\Ekstra;

use App\Models\Admin\Ekelas;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class NilaiEkstra extends Model
{
    //
    protected $table = 'ekstra_peserta';
    protected $fillable = [
        'nilai',
        'predikat',
    ];
    public function Siswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function KelasOne()
    {
       return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
