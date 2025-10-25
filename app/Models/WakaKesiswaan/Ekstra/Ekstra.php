<?php

namespace App\Models\WakaKesiswaan\Ekstra;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekstra extends Model
{
    use HasFactory;
    protected $table = 'ekstra';
    public function EkstraToDetailguru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
