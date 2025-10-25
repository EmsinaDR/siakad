<?php

namespace App\Models\WakaKurikulum\Perangkat;


use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class JadwalTest extends Model
{
    //
    protected $table = 'test_jadwal';

    protected $fillable = [
        'tapel_id',
        'semester',
        'tanggal_pelaksanaan',
        'durasi',
        'mapel_id',
        'ruang_test',
        'detailguru_id',
        'nomor_ruangan',
        'jam_mulai',
        'jam_selesai',
    ];
    public function Tapel()
    {
        return $this->belongsTo(Etapel::class);
    }

    public function Mapel()
    {
        return $this->belongsTo(Emapel::class);
    }

    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function detailGuru()
    {
        return $this->belongsTo(DetailGuru::class, 'detailguru_id');
    }
    public function mapeltest()
    {
        return $this->belongsTo(Emapel::class, 'mapel_id');
    }

}
