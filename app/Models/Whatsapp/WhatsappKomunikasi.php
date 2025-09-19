<?php

namespace App\Models\Whatsapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappKomunikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'detailsiswa_id','nomor_tujuan','isi_pesan','keterangan'
    ];

    protected $table = 'whatsapp_komunikasi';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
