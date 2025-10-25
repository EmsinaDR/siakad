<?php

namespace App\Models\WakaKesiswaan\Ekstra;

use App\Models\Admin\Ekelas;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use App\Models\WakaKesiswaan\Ekstra\Ekstra;

class DaftarHadirEkstra extends Model
{
    //
    protected $table = 'ekstra_daftar_hadir';
    protected $fillable = [
        'tingkat_id',
        'tapel_id',
        'ekstra_id',
        'detailsiswa_id',
        'tanggal_absen',
        'absensi',
    ];

    public function Siswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function Pembina()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Kelas()
    {
        return $this->hasOneThrough(
            Ekelas::class,    // Model tujuan
            Detailsiswa::class, // Model perantara
            'id',            // Foreign Key di DetailSiswa yang menghubungkan ke PesertaEkstra
            'id',            // Primary Key di Kelas
            'detailsiswa_id', // Foreign Key di PesertaEkstra ke DetailSiswa
            'kelas_id'       // Foreign Key di DetailSiswa ke Kelas
        );
    }
    public function Ekstra()
    {
       return $this->hasOne(Ekstra::class, 'id', 'ekstra_id');
    }

}
