<?php

namespace App\Models\Program\Rapat;

use App\Models\Admin\Etapel;
use Illuminate\Database\Eloquent\Model;

class DataRapat extends Model
{
    //
    protected $table = 'rapat_data';
    protected $fillable = [
        'tapel_id',
        'nomor_surat',
        'nama_rapat',
        'detailguru_id',
        'tanggal_pelaksanaan',
        'perihal',
        'vote_id',
        'jam_mulai',
        'jam_selesai',
        'tempat',
        'tembusan',
        'notulen',
        'keterngan',


    ];
    public function Tapel()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
}
