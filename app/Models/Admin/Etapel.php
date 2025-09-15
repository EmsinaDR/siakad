<?php

namespace App\Models\Admin;

use App\Models\Ekaldik;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etapel extends Model
{
    use HasFactory;
    protected $table = 'etapels';
    public function kaldik(): HasOne
    {
        return $this->hasOne(Ekaldik::class, 'kaldik_id');
    }
}
