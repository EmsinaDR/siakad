<?php

namespace App\Models\bk;

use App\Models\Admin\Ekelas;
use App\Models\bk\Ebkkreditpoint;
use Illuminate\Support\Facades\DB;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ebkpelanggaran extends Model
{
    use HasFactory;
    public function EbkPelanggaranKorbanToDetailsiswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'korban_id');
    }
    use HasFactory;
    public function EbkPelanggaranPelakuToDetailsiswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'pelaku_id');
    }

    public function EbkPelanggaranEkreditpoint()
    {
        return $this->hasOne(Ebkkreditpoint::class, 'id', 'kreditpoint_id');
    }
    public function siswa()
    {
        return $this->belongsTo(Detailsiswa::class, 'pelaku_id');
    }

    public function Ebkkreditpoint()
    {
        return $this->belongsTo(Ebkkreditpoint::class, 'kreditpoint_id');
    }

    public function kelas()
    {
        return $this->hasOneThrough(
            Ekelas::class,         // Model yang ingin diakses (akhir)
            DetailSiswa::class,   // Model perantara
            'id',                 // Foreign key di tabel perantara (detailsiswa -> kelas_id)
            'id',                 // Primary key di tabel tujuan (kelas -> id)
            'pelaku_id',      // Foreign key di tabel awal (pelanggaran -> detailsiswa_id)
            'kelas_id'             // Foreign key di tabel perantara (detailsiswa -> kelas_id)
        );
    }
    public function scopeWithSiswaDanKelas(Builder $query)
    {
        return $query->select(
            'detailsiswas.nama_siswa',  // Ambil nama siswa
            'ekelas.kelas',             // Ambil nama kelas
            'pelaku_id',
            DB::raw('SUM(point) as total_pelanggaran'),
            DB::raw('COUNT(*) as pelanggaran')
        )
            ->join('detailsiswas', 'ebkpelanggarans.pelaku_id', '=', 'detailsiswas.id')
            ->join('ekelas', 'detailsiswas.kelas_id', '=', 'ekelas.id')
            ->groupBy('pelaku_id', 'detailsiswas.nama_siswa', 'ekelas.kelas');
    }
}
