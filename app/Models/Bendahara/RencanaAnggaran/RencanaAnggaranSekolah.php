<?php

namespace App\Models\Bendahara\RencanaAnggaran;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bendahara\RencanaAnggaranList;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RencanaAnggaranSekolah extends Model
{
    use HasFactory;

    protected $table = 'keuangan_rencana_anggaran_sekolah';
    protected $fillable = [
        'rencana_anggaran_id', // <--- tambahkan ini
        'tanggal',
        'kode',
        'nominal',
        'keterangan',
        'tapel_id',
        'semester',
        'kategori',
        // tambahkan field lain kalau perlu
    ];
    public function RencanaAnggaranLis()
    {
        return $this->hasOne(RencanaAnggaranList::class, 'id', 'rencana_anggaran_id');
    }
}
