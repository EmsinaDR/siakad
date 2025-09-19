<?php

namespace App\Models\Bendahara\KasUmum;

use Illuminate\Database\Eloquent\Model;

class BendaharaKasUmum extends Model
{
    //
    protected $table = 'buku_kas_umum';
    protected $fillable = [
        'tapel_id',
        'petugas_id',
        'tanggal',
        'uraian',
        'sumber_dana',
        'penerimaan',
        'pengeluaran',
        'pemasukkan_bos_id',
        'pengeluaran_bos_id',
        'pemasukkan_komite_id',
        'pengeluaran_komite_id',
        'pemasukkan_csr_id',
        'pengeluaran_csr_id',
        'keterangan',
        'program',


    ];
}
