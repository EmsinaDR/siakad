<?php

namespace App\Models\Admin;

use App\Models\Admin\Etapel;
use Illuminate\Support\Facades\DB;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Program\Supervisi\SupervisiWaliKelas;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekelas extends Model
{
    use HasFactory;
    protected $tabel = 'ekelas';
    public function kelastoDetailguru(): HasOne
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function Guru(): HasOne
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function kelastotapel(): HasOne
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }

    public static function FindingWaliKelas($id)
    {
        $wakels = Ekelas::find($id);
        //dd($request->all());

        return $wakels->kelastoDetailguru;
    }
    // app/Models/Ekelas.php

    public function siswas()
    {
        return $this->hasMany(Detailsiswa::class, 'kelas_id');
    }

    //Absensi
    public function siswa()
    {
        return $this->hasMany(Detailsiswa::class, 'kelas_id');
    }
    //total absensi
    public function supervisiWaliKelas()
    {
        return $this->hasMany(SupervisiWaliKelas::class, 'kelas_id', 'id');
    }
}
