<?php

namespace App\Models\Jadwal;

use Illuminate\Database\Eloquent\Model;

class DataJadwal extends Model
{
    //
    protected $table = 'jadwal_pelajaran';
    protected $fillable = [
            'nama_jadwal',
            'tapel_id',
            'jam',
            'pelaksanaan',
            'kelas',


        ];

}
//
