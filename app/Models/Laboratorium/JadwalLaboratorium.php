<?php

namespace App\Models\Laboratorium;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use App\Models\Laboratorium\Laboratorium;

class JadwalLaboratorium extends Model
{
    //
    use HasFactory; // Mengaktifkan fitur factory
    protected $table = 'laboratorium_ijin';
    protected $fillable = [
        'laboran_id',
        'detailguru_id',
        'laboratorium_id',
        'tanggal_penggunaan',
        'tujuan',
        'tapel_id',
    ];
    public function Detailguru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Laboratorium()
    {
        return $this->hasOne(Laboratorium::class, 'id', 'laboratorium_id');
    }
}
