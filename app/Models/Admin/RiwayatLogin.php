<?php

namespace App\Models\Admin;

use App\Models\User\Guru\Detailguru;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;

class RiwayatLogin extends Model
{
    //
    protected $riwayat_login = 'riwayat_logins';
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'logged_in_at',

        ];
    public function user()
    {
       return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function RiwayatLoginToUser()
    {
       return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function RiwayatLoginToDetailguru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }

}
