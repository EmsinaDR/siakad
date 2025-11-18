<?php

namespace App\Models\Bendahara;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class BendaharaBos extends Model
{
    //
    protected $table = 'keuangan_bos';
    protected $fillable = [
        'petugas_id',
        'tapel_id',
        'pemasukkan',
        'pengeluaran',
        'bidang',
        'kategori',
        'nominal',
        'keterangan',
        'sumber_dana',

    ];
    public function Tapel()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'penerima_id');
    }
    public function RencanaAnggaran()
    {
       return $this->hasOne(RencanaAnggaran::class, 'id', 'jenis_pengeluaran_id');
    }
}
