<?php

namespace App\Models\Program\Prestasi;

use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;

class DataPrestasi extends Model
{
    //
    protected $table = 'data_prestasi';
    protected $fillable = [
        'tapel_id',
        'juara',
        'detailsiswa_id',
        'kategori',
        'kategori_lainnya',
        'pelaksanaan',
        'tingkat',
        'keterangan',
        'created_at',
        'updated_at',


        ];
        public function Siswa()
        {
           return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
        }
}
