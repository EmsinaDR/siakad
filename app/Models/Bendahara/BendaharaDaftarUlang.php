<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Model;

class BendaharaDaftarUlang extends Model
{
    //
    protected $table = 'keuangan_du';
    protected $fillable = [
        'tapel_id',
        'semester',
        'petugas_id',
        'nomor_pembayaran',
        'items',
        'detailsiswa_id',
        'kelas_id',
        'nominal',


        ];
}
