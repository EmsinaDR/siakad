<?php

namespace App\Models\Admin;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RoleUser extends Model
{
    //
    protected $table = 'role_user';
    // public function role_to_user(): belongsToMany
    // {
    //     // return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    //     return $this->belongsToMany(User::class, 'role_user', 'user_id', 'role_id');
    // }
    //  public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }

    // // Menghubungkan Role ke DetailGuru melalui User
    // public function detailGurus()
    // {
    //     return $this->hasManyThrough(
    //         DetailGuru::class, // Model tujuan akhir
    //         User::class,       // Model perantara
    //         'role_id',         // Foreign key di role_user yang menghubungkan ke roles
    //         'user_id',         // Foreign key di detail_guru yang menghubungkan ke users
    //         'id',              // Primary key di roles
    //         'id'               // Primary key di users
    //     );
    // }
}
