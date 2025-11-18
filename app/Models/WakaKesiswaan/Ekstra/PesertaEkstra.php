<?php

namespace App\Models\WakaKesiswaan\Ekstra;

use App\Models\Admin\Ekelas;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class PesertaEkstra extends Model
{
    //
    protected $table = 'ekstra_peserta';
    protected $fillable = [
        'detailguru_id',
        'detailsiswa_id',
        'tapel_id',
        'ekstra_id',
        'nilai',
        'jabatan',
        'predikat',
        'tingkat_id',
        'kelas_id',
    ];

    public function Siswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function KelasOne()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function Pembina()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Kelas()
    {
        return $this->hasOneThrough(
            Ekelas::class,    // Model tujuan
            DetailSiswa::class, // Model perantara
            'id',            // Foreign Key di DetailSiswa yang menghubungkan ke PesertaEkstra
            'id',            // Primary Key di Kelas
            'detailsiswa_id', // Foreign Key di PesertaEkstra ke DetailSiswa
            'kelas_id'       // Foreign Key di DetailSiswa ke Kelas
        );
    }
    public function Ekstra()
    {
       return $this->hasOne(RiwayatEkstra::class, 'id', 'ekstra_id');
    }
    public function EkstraOne()
    {
       return $this->hasOne(Ekstra::class, 'id', 'ekstra_id');
    }
    public function EkstraNew()
    {
        return $this->hasOneThrough(
            Ekstra::class,       // Model tujuan (Ekstra)
            RiwayatEkstra::class, // Model perantara (RiwayatEkstra)
            'id',                // Foreign key di RiwayatEkstra (relasi ke PesertaEkstra)
            'id',                // Primary key di Ekstra
            'ekstra_id',         // Foreign key di PesertaEkstra (menuju RiwayatEkstra)
            'ekstra_id'          // Foreign key di RiwayatEkstra (menuju Ekstra)
        );
    }
}
