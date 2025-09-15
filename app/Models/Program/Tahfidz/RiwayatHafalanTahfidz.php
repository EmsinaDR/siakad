<?php

namespace App\Models\Program\Tahfidz;

use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatHafalanTahfidz extends Model
{
    //
    use HasFactory;

    protected $table = 'tahfidz_riwayat';
    protected $fillable = [
        'detailsiswa_id',
        'pembimbing_id',
        'surat_id',
        'ayat',
        'keterangan'
    ];


    public function siswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function pembimbing()
    {
        return $this->belongsTo(Detailguru::class, 'pembimbing_id');
    }

    public function surat()
    {
        return $this->hasOne(TahfidzSurat::class, 'id', 'surat_id');
    }
}
