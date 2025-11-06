<?php

namespace App\Models\Whatsapp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjadwalanPesan extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'jam',
        'judul',
        'tanggal',
        'no_hp',
        'scheduled_at',
        'response',
        'tapel_id',
        'tipe_tujuan',
        'tujuan',
        'tujuan_nomor',
        'pesan',
        'message',
        'status',
        'gambar',
        'session',
    ];

    protected $table = 'penjadwalan_pesan';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
