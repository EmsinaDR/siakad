<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Model;

class RencanaAnggaranList extends Model
{
    //
    protected $table = 'keuangan_rencana_anggaran_sekolah_list';
    protected $fillable = [
        'kode',
        'jenis_pengeluaran',
        'keterangan',


        ];
}
