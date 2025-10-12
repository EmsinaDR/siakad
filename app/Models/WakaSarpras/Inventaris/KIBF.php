<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Model;

class KIBF extends Model
{
    protected $table = 'inventaris_kibf';

    protected $fillable = [
        'barang_id',
        'nama_barang',
        'jumlah',
        'tahun_masuk',
        'lokasi',
        'status',
    ];
}
/*

'barang_id' => 'nullable|integer',
'nama_barang' => 'required|string|max:255',
'jumlah' => 'required|integer|min:1',
'tahun_masuk' => 'required|integer|min:1900|max:' . date('Y'),
'lokasi' => 'required|string|max:255',
'status' => 'required|in:Baik,Rusak Ringan,Rusak Sedang,Rusak Berat',

*/