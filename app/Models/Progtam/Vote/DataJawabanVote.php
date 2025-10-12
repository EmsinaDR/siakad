<?php

namespace App\Models\Progtam\Vote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJawabanVote extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
    ];

    protected $table = 'vote_jawaban';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
