<?php

namespace App\Models\Laboratorium;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elaboratorium extends Model
{
    use HasFactory;
    protected $table = 'laboratorium';
    // public function ElabsUsers(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }
    public function ElabsDetailGurus(): HasOne
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function elaboratorium()
    {
       return $this->hasOne(Elaboratorium::class, 'id', 'laboratorium_id');
    }
}
