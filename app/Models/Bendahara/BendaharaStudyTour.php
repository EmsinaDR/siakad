<?php

namespace App\Models\Bendahara;

use App\Models\Admin\Ekelas;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class BendaharaStudyTour extends Model
{
    //
    protected $table = 'keuangan_study_tour';
    protected $fillable = [
        'tapel_id',
        'study_tour_riwayat',
        'petugas_id',
        'nomor_pembayaran',
        'kelas_id',
        'detailsiswa_id',
        'nominal',
        'keterangan',

    ];
    public function BendaharaStudyTourToDetailsiswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function BendaharaStudyTourTokelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
