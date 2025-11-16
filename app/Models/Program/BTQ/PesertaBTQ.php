<?php

namespace App\Models\Program\BTQ;

use App\Models\Admin\Ekelas;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class PesertaBTQ extends Model
{
    //

    protected $table = 'btq_peserta';
    protected $fillable = [
        'detailsiswa_id',
        'pembimbing_id',
        'hari_bimbingan',
        'keterangan',
    ];
    public function SiswaOne()
    {
       return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'pembimbing_id');
    }
    public function kelas()
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
