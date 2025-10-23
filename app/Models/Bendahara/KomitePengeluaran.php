<?php

namespace App\Models\Bendahara;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bendahara\RencanaAnggaranList;

class KomitePengeluaran extends Model
{
    //
    protected $table = 'keuangan_pengeluaran_komite';
    protected $fillable = [
        'tapel_id',
        'semester',
        'petugas_id',
        'detailguru_id',
        'penerima_id',
        'nominal',
        'keterangan',
        'jenis_pengeluaran_id',


    ];
    // KomitePengeluaran.php
    public function rencanaAnggaranList()
    {
        return $this->belongsTo(RencanaAnggaranList::class, 'jenis_pengeluaran_id');
    }

    public function KomitePengeluaranToDetailguru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'penerima_id');
    }
    // public function RencanaAnggaran()
    // {
    //     return $this->hasOne(RencanaAnggaran::class, 'id', 'jenis_pengeluaran_id');
    // }
    public function rencanaAnggaran()
    {
        return $this->belongsTo(RencanaAnggaran::class, 'jenis_pengeluaran_id');
    }

    // public function rencanaAnggaran()
    // {
    //     return $this->belongsTo(RencanaAnggaran::class, 'rencana_anggaran_id');
    // }
    // public function rencanaAnggaranList()
    // {
    //     return $this->hasOneThrough(
    //         RencanaAnggaranList::class,     // Tujuan akhir
    //         RencanaAnggaran::class,         // Model perantara
    //         'id',         // FK lokal di KomitePengeluaran
    //         'id',          // FK di RencanaAnggaranList yang menunjuk ke RencanaAnggaran
    //         'id',                            // FK di RencanaAnggaran yang diacu oleh KomitePengeluaran
    //         'jenis_pengeluaran_id',                             // Local key di RencanaAnggaran

    //     );
    // }
}
// hasOneThrough(
//     ModelTujuanAkhir::class,   // RencanaAnggaranList
//     ModelPerantara::class,     // RencanaAnggaran
//     ForeignKeyDiPerantara,     // foreign key di RencanaAnggaran yang mengarah ke KomitePengeluaran
//     ForeignKeyDiTujuanAkhir,   // foreign key di RencanaAnggaranList yang mengarah ke RencanaAnggaran
//     KunciLokal,                // foreign key di KomitePengeluaran
//     KunciPerantara             // foreign key di RencanaAnggaran yang mengarah ke RencanaAnggaranList
// )
