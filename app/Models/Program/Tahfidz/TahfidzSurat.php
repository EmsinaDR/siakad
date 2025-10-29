<?php

namespace App\Models\Program\Tahfidz;

use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahfidzSurat extends Model
{
    //
    use HasFactory;

    protected $table = 'tahfidz_surat';
    protected $fillable = ['arab', 'nama_surat', 'jumlah_ayat', 'keterangan'];
}
