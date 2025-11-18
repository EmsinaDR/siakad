<?php

namespace App\Models\User\Alumni;

use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class PengajuanLegalisir extends Model
{
    //
    protected $table = 'pengajuan_legalisir';

    protected $fillable = [
        'detailsiswa_id',
        'tahun_lulus',
        'jumlah_lembar',
        'keperluan',
        'status',
    ];
    public function Siswa()
    {
       return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
}
