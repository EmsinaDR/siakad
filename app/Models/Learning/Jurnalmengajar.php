<?php

namespace App\Models\Learning;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurnalmengajar extends Model
{

    use HasFactory;
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
    public function EjurnalmengajaraToDetailguru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
