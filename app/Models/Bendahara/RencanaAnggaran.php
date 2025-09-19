<?php

namespace App\Models\Bendahara;

use App\Models\Bendahara\RencanaAnggaranList;
use Illuminate\Database\Eloquent\Model;

class RencanaAnggaran extends Model
{
    //
    protected $table = 'keuangan_rencana_anggaran_sekolah';
    protected $fillable = [
        'rencana_anggaran_id', // <--- tambahkan ini
        'kode',
        'rencana_anggaran_id',
        'nominal',
        'keterangan',
        'tapel_id',
        'semester',
        'tanggal',
        // tambahkan field lain kalau perlu
    ];
    public function RencanaAnggaranLis()
    {
        return $this->hasOne(RencanaAnggaranList::class, 'id', 'rencana_anggaran_id');
    }
    // public function list()
    // {
    //     return $this->hasMany(RencanaAnggaranList::class, 'rencana_anggaran_id');
    // }

}
