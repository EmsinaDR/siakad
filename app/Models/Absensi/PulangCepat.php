<?php

namespace App\Models\Absensi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PulangCepat extends Model
{
    // use HasFactory;

    // protected $fillable = [
    //     // Tentukan field yang bisa diisi
    //     'fillable'
    // ];

    // protected $table = 'pulang_cepat';  // Misalkan model ini menggunakan nama tabel khusus

    // protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // // Tambahkan relasi atau metode lain jika diperlukan
    protected $table = null;

    // Nonaktifkan timestamps (created_at, updated_at)
    public $timestamps = false;

    // Lindungi agar tidak ada query ke DB
    public function getTable()
    {
        return null;
    }
}
