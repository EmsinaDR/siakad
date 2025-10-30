<?php

namespace App\Models\Jadwal;

use App\Models\Admin\Ekelas;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    //
    protected $table = 'jadwal_pelajaran';
    protected $fillable = [
        'waktu',         // Jika waktu juga bisa diedit
        'detailguru_id', // Untuk menyimpan referensi ke DetailGuru
        'nama_jadwal',
        'jam',
        'tapel_id',
        'kelas_id',
        'tingkat_id',
        'mapel_id',
        'hari',
    ];
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Kelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
