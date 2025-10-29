<?php

namespace App\Models\AdminDev;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;

    protected $fillable = [
        'modul',
        'slug',
        'route',
        'is_active',
        'provider_class',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public $timestamps = true;
    protected $table = 'modul';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
