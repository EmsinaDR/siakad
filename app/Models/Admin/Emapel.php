<?php

namespace App\Models\Admin;

use App\Models\Program\CBT\BankSoal;
use Illuminate\Database\Eloquent\Model;
use App\Models\WakaKurikulum\Perangkat\JadwalTest;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Emapel extends Model
{
    use HasFactory;
    protected $table = 'emapels';
    protected $fillable = [
        'tapel_id',
        'mapel_id',
        'detailguru_id',
        'Ekelas_id',
        '_token',
        'jtm',
    ];
    public function jadwalTests()
    {
        return $this->hasMany(\App\Models\WakaKurikulum\Perangkat\JadwalTest::class, 'mapel_id');
    }
    public function bankSoals()
    {
        return $this->hasMany(BankSoal::class);
    }
}
