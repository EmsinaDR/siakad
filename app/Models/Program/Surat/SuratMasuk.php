<?php

namespace App\Models\Program\Surat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;
    // Tentukan kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'tapel_id',
        'klasifikasi_id',
        'nomorl_surat',
        'tanggal_surat',
        'tanggal_terima',
        'jenis_pengirim',
        'nama_pengirim',
        'buku_tamu_id',
        'kategori',
        'perihal',
        'lampiran',
        'status',
        'keterangan',
    ];

    protected $table = 'surat_masuk';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Klasifikasi()
    {
       return $this->hasOne(SuratKlasifikasi::class, 'id', 'klasifikasi_id');
    }
}
