<?php

namespace App\Models\Bendahara\BOS;

use App\Models\Admin\Etapel;
use App\Models\Bendahara\BendaharaBos;
use App\Models\Bendahara\RencanaAnggaran;
use App\Models\Bendahara\RencanaAnggaranList;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuKasBOS extends Model
{
    use HasFactory;

    protected $fillable = [
        'tapel_id',
        'petugas_id',
        'tanggal',
        'sumber_dana',
        'uraian',
        'jenis_pengeluaran_id',
        'pemasukkan_id',
        'pengeluaran_id',
        'pemasukkan',
        'pengeluaran',
        'keterangan',
    ];


    protected $table = 'kas_bos';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Tapel()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
    public function Petugas()
    {
        return $this->hasOne(Detailguru::class, 'id', 'petugas_id');
    }
    public function Pemasukkan()
    {
        return $this->hasOne(BendaharaBos::class, 'id', 'pemasukkan_id');
    }
    public function SumberDana()
    {
        return $this->hasOne(BendaharaBos::class, 'id', 'sumber_dana');
    }
    public function Anggraran()
    {
        return $this->hasOne(RencanaAnggaran::class, 'id', 'jenis_pengeluaran_id');
    }
}


// 'tapel_id' => 'nullable|exists:etapels,id',
//         'petugas_id' => 'nullable|exists:detailgurus,id',
//         'tanggal' => 'required|date',
//         'uraian' => 'required|string|max:255',
//         'jenis_pengeluaran_id' => 'nullable|exists:keuangan_rencana_anggaran_sekolah,id',
//         'pemasukkan_id' => 'nullable|exists:keuangan_bos,id',
//         'pengeluaran_id' => 'nullable|exists:keuangan_pengeluaran_bos,id',
//         'pemasukkan' => 'nullable|numeric|min:0',
//         'pengeluaran' => 'nullable|numeric|min:0',
//         'keterangan' => 'nullable|string|max:255',