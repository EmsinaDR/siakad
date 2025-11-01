<?php

namespace App\Models\Learning;

use App\Models\Admin\Emapel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Emateri extends Model
{
    use HasFactory;
    protected $fillable = [
        '_token'


        ];
    public function EmaeritoMapel()
    {
        return $this->hasOne(emapel::class, 'id', 'mapel_id');
    }
}
