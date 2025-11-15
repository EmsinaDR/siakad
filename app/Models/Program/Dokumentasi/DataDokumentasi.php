<?php

namespace App\Models\Program\Dokumentasi;

use App\Models\Admin\Etapel;
use Illuminate\Database\Eloquent\Model;

class DataDokumentasi extends Model
{
    //
    protected $table = 'dokumentasi_data';
    protected $fillable = [
        'tapel_id',
        'nama_kegiatan',
        'foto',
        'keterangan',
        'tanggal_pelaksanaan',
        'detailguru_id',
    ];
    public function Tapel()
    {
       return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
}
