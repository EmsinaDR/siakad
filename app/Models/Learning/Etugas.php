<?php

namespace App\Models\Learning;

use App\Models\Admin\Ekelas;
use App\Models\Learning\Emateri;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etugas extends Model
{
   use HasFactory;
   // protected $table = 'etugas';
   protected $fillable = [
      '_method',
      'tapel_id',
      'detailguru_id',
      'kelas_id',
      'mapel_id',
      'materi',
      'sub_materi',
      'deadline',
      'indikator_id',
      'keterangan',
      'updated_at',
   ];
   public function etugastokelas()
   {
      return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
   }
   public function etugastomateri()
   {
      return $this->hasOne(Emateri::class, 'id', 'indikator_id');
   }
   public function etugastodetailguru()
   {
      return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
   }
}
