<?php

namespace App\Models\Program\CBT;

use Illuminate\Database\Eloquent\Model;

class AnalisisTest extends Model
{
    //
    protected $table = 'jawaban_cbt';
    protected $fillable = [
        'user_id',
        'soal_id',
        'test_id',
        'jawaban',
        'benar',
        'mapel_id',
        'detailguru_id',
    ];
}
