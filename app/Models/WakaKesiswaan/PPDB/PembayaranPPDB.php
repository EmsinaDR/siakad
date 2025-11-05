<?php

namespace App\Models\WakaKesiswaan\PPDB;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class PembayaranPPDB extends Model
{
    //
    protected $table = 'ppdb_pembayaran';

    protected $fillable = [
        'detailguru_id',
        'calon_id',
        'nominal',
    ];

    public function detailGuru()
    {
        return $this->belongsTo(Detailguru::class, 'detailguru_id');
    }

    public function calon()
    {
        return $this->belongsTo(PpdbPeserta::class, 'calon_id');
    }
    public function PPDBPeserta()
    {
        return $this->belongsTo(PPDBPeserta::class, 'pengumuman_id');
        // Foreign key menghubungkan ke PengumumanPPDB
    }
    public function pengumuman()
    {
        return $this->belongsTo(PengumumanPPDB::class, 'pengumuman_id', 'id');
    }
}
