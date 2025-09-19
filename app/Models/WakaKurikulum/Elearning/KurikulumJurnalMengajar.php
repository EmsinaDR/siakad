<?php

namespace App\Models\WakaKurikulum\Elearning;

use App\Models\Admin\Ekelas;
use App\Models\User\Guru\Detailguru;
use App\Models\Learning\Jurnalmengajar;
use Illuminate\Database\Eloquent\Model;

class KurikulumJurnalMengajar extends Model
{
    //
    protected $table = 'ejurnalmengajars';
    protected $fillable = [
        'mapel_id',
        'semester',
        'tingkat_id',
        'kelas_id',
        'detailguru_id',
        'pertemuan_ke',
        'jam_ke',
        'siswa_alfa',
        'siswa_bolos',
        'siswa_ijin',
        'siswa_sakit',
        'kejadian_khusus',
        'materi',
        'sub_materi',
        'indikator_id',
        'tapel_id',
        'semester',
    ];
    public function EjurnalToEmateris()
    {
        return $this->hasOne(Jurnalmengajar::class, 'id', 'indikator_id');
    }
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }

    public function Kelas()
    {
       return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
