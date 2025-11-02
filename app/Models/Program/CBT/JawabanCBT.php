<?php

namespace App\Models\Program\CBT;

use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class JawabanCBT extends Model
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
    public function test()
    {
        return $this->belongsTo(CBTJadwal::class, 'test_id');
    }
    public function Siswa()
    {
       return $this->hasOne(Detailsiswa::class, 'id', 'user_id');
    }
}
