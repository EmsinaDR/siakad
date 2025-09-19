<?php

namespace App\Models\WakaKurikulum\Elearning\Nilai;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class KurikulumNilaiUH extends Model
{
   //
   protected $table = 'enilai_ulangans';
   protected $fillable = [
      'field_one',
      'field_two',


   ];
   public function Siswa()
   {
      return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
   }
   public function Kelas()
   {
      return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
   }
   public function Mapel()
   {
      return $this->hasOne(Emapel::class, 'id', 'mapel_id');
   }
   public function detailsiswa()
   {
      return $this->belongsTo(Detailsiswa::class, 'detailsiswa_id', 'id');
   }
   public function DataGuru()
   {
      return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
   }
}
