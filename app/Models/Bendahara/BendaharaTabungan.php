<?php

namespace App\Models\Bendahara;

use App\Models\Admin\Ekelas;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class BendaharaTabungan extends Model
{
    //
    protected $table = 'keuangan_tabungan';
    protected $fillable = [
        'tapel_id',
        'tingkat_id',
        'kelas_id',
        'detailsiswa_id',
        'pemasukan',
        'petugas_id',
        'type',
        'nominal',


    ];
    public function BendaharaTabunganToDetailguru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'petugas_id');
    }
    public function BendaharaTabunganToKelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function BendaharaTabunganToDetailsiswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function siswa()
    {
        //dd($request->all());
        return $this->belongsTo(Detailsiswa::class, 'detailsiswa_id');

    }
}
