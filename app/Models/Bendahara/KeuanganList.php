<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Model;

class KeuanganList extends Model
{
    //
    protected $table = 'keuangan_lists';
    protected $fillable = ['tapel_id', 'kategori', 'nominal', 'petugas_id', 'singkatan', 'jenis_pembayaran', 'keterangan'];
}
