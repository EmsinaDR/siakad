<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarisPengajuan extends Model
{
    use HasFactory;
    protected $table = 'inventaris_pengajuan';
    protected $fillable = [
            'field_one',
            'field_two',
    
    
        ];
}
