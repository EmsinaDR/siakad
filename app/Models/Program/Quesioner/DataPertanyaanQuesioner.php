<?php

namespace App\Models\Program\Quesioner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPertanyaanQuesioner extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'detailsiswa_id','detailguru_id','pertanyaan','jawaban','keterangan'
    ];

    protected $table = 'data_pertanyaan_quesioner';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
