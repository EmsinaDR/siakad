<?php

namespace App\Models\Bendahara;

use Illuminate\Database\Eloquent\Model;

class KeuanganRiwayatList extends Model
{
    //
    protected $table = 'keuangan_riwayat_lists';
    protected $fillable = [
        'petugas_id',
        'tapel_id',
        'semester',
        'semester',
        'tingkat_id',
        'kategori',
        'jenis_pembayaran',
        'nominal',
        'keterangan',
        'created_at',
        'updated_at'


        ];
}
// ->sum('nominal')