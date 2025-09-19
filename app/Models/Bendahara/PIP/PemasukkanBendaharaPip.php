<?php

namespace App\Models\Bendahara\PIP;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemasukkanBendaharaPip extends Model
{
   use HasFactory;


   protected $fillable = [
      'tapel_id',
      'detailsiswa_id',
      'detailguru_id',
      'tanggal_penerimaan',
      'nominal',
      'kelas_id',
      'keterangan',
      'tahap',
   ];
   protected $table = 'pemasukkan_pip';  // Misalkan model ini menggunakan nama tabel khusus

   protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

   // Tambahkan relasi atau metode lain jika diperlukan
   public function Tapel()
   {
      return $this->hasOne(Etapel::class, 'id', 'tapel_id');
   }
   public function Guru()
   {
      return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
   }
   public function Siswa()
   {
      return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
   }
   public function Kelas()
       {
           return $this->hasOneThrough(
               Ekelas::class,        // Model tujuan akhir
               Detailsiswa::class,  // Model perantara
               'id',                // FK di Detailsiswa yang mengarah ke Kelas (kelas_id)
               'id',                // FK di Kelas
               'detailsiswa_id',     // FK di PesertaTahfidz yang mengarah ke Detailsiswa
               'kelas_id'           // FK di Detailsiswa yang mengarah ke Kelas
           );
       }
}
