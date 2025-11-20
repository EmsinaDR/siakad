<?php

namespace App\Models\Laboratorium;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elabijin extends Model
{
    use HasFactory;
    protected $table = 'laboratorium_ijin';
    protected $fillable = [
        'detailguru_id',
        'laboratorium_id',
        'tanggal_penggunaan',
        'tujuan'
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
