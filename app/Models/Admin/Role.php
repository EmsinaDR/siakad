<?php

namespace App\Models\Admin;

use App\Models\User\Guru\Detailguru;
use Illuminate\Foundation\Auth\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;
    protected  $table = 'roles';
    // public function User(): belongsTo
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function roletousers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function roletodetailgurus(): BelongsToMany
    {
        return $this->belongsToMany(Detailguru::class);
    }
    public function roletoUsermany()
    {
    //    return $this->hasMany(User::class);
       return $this->hasMany(User::class, 'user_id', 'role_id');
    }
    // Menghubungkan Role ke DetailGuru melalui User
    public function detailGurus()
    {
        return $this->hasManyThrough(
            DetailGuru::class, // Model tujuan akhir
            User::class,       // Model perantara
            'detailguru_id',         // Foreign key di role_user yang menghubungkan ke roles
            'user_id',         // Foreign key di detail_guru yang menghubungkan ke users
            // 'detailguru_id',         // Foreign key di role_user yang menghubungkan ke roles
            'id',              // Primary key di roles
            'id'               // Primary key di users
        );
    }
}
