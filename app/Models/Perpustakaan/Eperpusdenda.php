<?php

namespace App\Models\Perpustakaan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eperpusdenda extends Model
{
    use HasFactory;
    protected $fillable = [
        'detailsiswa_id',
        'hari',
        'nominal',
    ];
    public function siswa()
    {
        return $this->belongsTo(\App\Models\User\Siswa\Detailsiswa::class, 'detailsiswa_id');
    }
}
