<?php

namespace App\Models;
// C:\laragon\www\siakad\app\Models\GuruPiket.php

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class GuruPiket extends Model
{
    //
    protected $table = 'jadwal_piket';
    protected $fillable = [
        'tapel_id',
        'detailguru_id',
        'hari',
    ];
    public function guru()
    {
        return $this->belongsTo(Detailguru::class, 'detailguru_id', 'id');
    }
}
