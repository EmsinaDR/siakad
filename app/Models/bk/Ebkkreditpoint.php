<?php

namespace App\Models\bk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebkkreditpoint extends Model
{
    use HasFactory;
    public function pelanggaran()
    {
        return $this->hasMany(\App\Models\bk\Ebkpelanggaran::class, 'kreditpoint_id');
    }
}
