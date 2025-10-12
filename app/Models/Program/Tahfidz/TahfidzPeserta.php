<?php

namespace App\Models\Program\Tahfidz;


use App\Models\Admin\Ekelas;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahfidzPeserta extends Model
{
    use HasFactory;

    protected $table = 'tahfidz_peserta';
    protected $fillable = [
        'detailsiswa_id',
        'pembimbing_id',
        'hari_bimbingan',
        'keterangan',
    ];

    public function SiswaOne()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function siswa()
    {
        return $this->belongsTo(Detailsiswa::class, 'detailsiswa_id');
    }


    public function pembimbing()
    {
        return $this->belongsTo(Detailguru::class, 'pembimbing_id');
    }
    public function kelas()
    {
        return $this->hasOneThrough(
            Ekelas::class,        // Model tujuan akhir
            Detailsiswa::class,  // Model perantara
            'id',                // FK di Detailsiswa yang mengarah ke Kelas (kelas_id)
            'id',                // FK di Kelas
            'detailsiswa_id',     // FK di PesertaTahfidz yang mengarah ke Detailsiswa
            'kelas_id'           // FK di Detailsiswa yang mengarah ke Kelas
        );
    }
}


/*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.program.tahfidz.tahfidz-surat
php artisan make:view role.program.tahfidz.tahfidz-surat-single
php artisan make:model Program/Tahfidz/TahfidzSurat
php artisan make:controller Program/Tahfidz/TahfidzSuratController --resource




'detailsiswa_id' => 'nullable|exists:detailsiswas,id',
'pembimbing_id' => 'nullable|exists:detailgurus,id',
'keterangan' => 'nullable|string|max:255',


*/