<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Model;

class BukukasKomite extends Model
{
    //
    protected $table = 'kas_komite';
    protected $fillable = [
        'tanggal',
        'petugas_id',
        'uraian',
        'program',
        'penerimaan',
        'pengeluaran',
        'keterangan',
        'tapel_id',
        'pemasukkan_id',
        'pengeluaran_id',
    ];
}
