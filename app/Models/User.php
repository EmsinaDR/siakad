<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\elab;
use App\Models\Admin\Ekelas;
// use App\Models\Detailguru;
use App\Models\Admin\Role;
use App\Models\User\Guru\Detailguru;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Database\Eloquent\Relations\belongsTo;
use App\Models\Laboratorium\Elaboratorium;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
// use Illuminate\Database\Eloquent\Factories\BelongsToRelationship;
// use Illuminate\Database\Eloquent\Factories\BelongsToManyRelationship;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'posisi',
        'aktiv',
        'tingkat_id',
        'kelas_id',
        'detailguru_id',
        'detailsiswa_id',
        'name',
        'email',
        'email_verified_at',
        'password',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function showUsersq()
    {


        $users = User::get();
        return $users;
    }
    public function UsertoRole(): belongsToMany
    {
        // return $this->belongsToMany(Role::class);
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
    public static function colction_userx(User $user)
    {
        // foreach ($user->name as $user):
        //     $RoldeUser[] = $user->name;
        // endforeach;
        // // dd($RoldeUser);
        // return $RoldeUser;
    }
    public function cekusert($ceking)
    {

        $users = User::find(Auth::User()->id);
        foreach ($users->roles as $role):
            $gab_role[] = $role->name;
        endforeach;
        $gab_role = collect($gab_role);
        $gab_rolex = $gab_role->contains($ceking);
        // dd($gab_role->contains('Pembina Lab'));
        return $gab_rolex;
    }
    // public function allrole()
    // {
    //     // $roledata = User::find(User::id);
    //     // $roledata = User::Role();
    //     // return $roledata;
    // }
    // public function RoleTambahan()
    // {

    //     // $roletambahan = $this->hasMany(Role::class, 'user_id');
    //     // return $this->hasMany(Role::class, 'user_id');
    //     // return $this->hasMany(RoleTambahan::class, 'user_id');
    // }
    /**
     * Get the Detailsiswa associated with the User
     *
     * @eturn
     */
    // public function Detailsiswa(): HasOne
    // {
    //     return $this->hasOne(Detailsiswa::class, 'user_id', 'id');
    // }



    public function UsersDetailsiswa(): HasOne
    {
        return $this->hasOne(Detailsiswa::class);
    }






    // public function DetailGurutouser(): BelongsTo
    // {
    //     // $user = User::with('UsersDetailgurus')->where('posisi', 'Guru')->get();
    //     // return $this->hasOne(Detailguru::class);
    //     return $this->belongsTo(Detailguru::class);
    // }
    // public function UsersDetailgurus(): HasOne
    // {
    //     // $user = User::with('UsersDetailgurus')->where('posisi', 'Guru')->get();
    //     // return $this->hasOne(Detailguru::class);
    //     return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    // }
    public function UsersDetailgurus()
    {
        return $this->belongsTo(\App\Models\User\Guru\Detailguru::class, 'detailguru_id');
    }

    public function UsersElabs(): HasOne
    {
        return $this->hasOne(Elaboratorium::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function detailGuru()
    {
        // return $this->hasOne(DetailGuru::class);
        return $this->belongsTo(DetailGuru::class, 'detailguru_id');
    }
    public function Guru()
    {
        return $this->hasOne(DetailGuru::class, 'id', 'detailguru_id');
    }
    public function riwayatLogins()
    {
        return $this->hasMany(RiwayatLogin::class, 'user_id');
    }
    // public function SiswaKelas()
    // {
    //     return $this->hasOneThrough(
    //         Ekelas::class,     // Model tujuan akhir
    //         Detailsiswa::class,       // Model penghubung
    //         'user_id',     // Foreign key di tabel users_detail_siswa → users
    //         'siswa_id',    // Foreign key di tabel detailsiswa_to_kelas → users_detail_siswa
    //         'id',          // Local key di tabel users
    //         'kelas_id'           // Local key di tabel users_detail_siswa
    //     );
    // }
    public function SiswaKelas()
    {
        return $this->hasOneThrough(
            Ekelas::class,        // Model tujuan akhir
            Detailsiswa::class,  // Model perantara
            'id',                // FK di Detailsiswa yang mengarah ke Kelas (kelas_id)
            'id',                // FK di Kelas
            'detailsiswa_id',     // FK di PesertaTahfidz yang mengarah ke Detailsiswa
            'kelas_id'           // FK di Detailsiswa yang mengarah ke Kelas
        );
    }
}
