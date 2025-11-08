<?php

namespace App\Models\Program\CBT;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class CBTJadwal extends Model
{
    //
    protected $table = 'jadwal_cbt';
    protected $fillable = [
        'nama_test',
        'tapel_id',
        'detailguru_id',
        'kelas_id',
        'soal_id',
        'mapel_id',
        'waktu',
        'tanggal_pelaksanaan',
    ];
    protected $casts = [
        'soal_id' => 'array',
    ];
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Mapel()
    {
        return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }
    public function Kelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
