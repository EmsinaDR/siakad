<?php

namespace App\Models\Bendahara\RencanaAnggaran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaAnggaranList extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'kode',
        'jenis_pengeluaran',
        'kategori',
        'keterangan',
    ];

    protected $table = 'keuangan_rencana_anggaran_sekolah_list';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
