<?php

namespace App\Models\Bendahara\BOS;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bendahara\RencanaAnggaran;
use App\Models\Bendahara\RencanaAnggaranList;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengeluaranBOS extends Model
{
    use HasFactory;

    protected $fillable = [
        'tapel_id',
        'petugas_id',
        'penerima_id',
        'keuangan_bos_id',
        'nominal',
        'nota',
        'jenis_pengeluaran_id',
        'keterangan',
    ];


    protected $table = 'keuangan_pengeluaran_bos';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan

    public function Tapel()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'penerima_id');
    }
    public function RencanaAnggaran()
    {
        return $this->hasOne(RencanaAnggaranList::class, 'id', 'jenis_pengeluaran_id');
    }
    public function rencanaAnggaranList()
    {
        return $this->belongsTo(RencanaAnggaranList::class, 'jenis_pengeluaran_id');
    }
}
