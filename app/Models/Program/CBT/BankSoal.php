<?php

namespace App\Models\Program\CBT;

use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankSoal extends Model
{
    //
    use HasFactory;
    protected $table = 'banksoals';

    protected $fillable = [
        'indikator',
        'system',
        'detailguru_id',
        'tingkat_id',
        'mapel_id',
        'materi',
        'sub_materi',
        'bentuk',
        'level',
        'soal',
        'jawabaa',
        'jawabanb',
        'jawabanc',
        'jawaband',
        'kunci'
    ];

    // Relasi ke tabel Emapel (Mapel)
    public function mapel()
    {
        return $this->belongsTo(Emapel::class, 'mapel_id');
    }

    // Relasi ke tabel DetailGuru
    public function detailGuru()
    {
        return $this->belongsTo(Detailguru::class, 'detailguru_id');
    }
}

