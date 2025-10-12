<?php

namespace App\Models\Absensi;

use App\Models\Admin\Ekelas;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Eabsen extends Model
{
    use HasFactory;
    // protected $table = 'eabsens_siswa';
    protected $table = 'eabsens_siswa';
    protected $fillable = [
        'tapel_id',
        'telat',
        'semester',
        'waktu_absen',
        'jenis_absen',
        'detailsiswa_id',
        'kelas_id',
        'absen',
        'pulang_telat',
        'whatsapp_response',

    ];
    protected $casts = [
        'telat' => 'boolean',
    ];
    public function EabsentoDetailsiswa()
    {
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');
    }
    public function detailsiswa()
    {
        return $this->belongsTo(Detailsiswa::class, 'detailsiswa_id');
    }

    public static function jumlahAbsenHariIni()
    {
        return Ekelas::select('ekelas.id', 'ekelas.kelas')
            ->join('detailsiswas', 'detailsiswas.kelas_id', '=', 'ekelas.id')
            ->join('eabsens_siswa', 'eabsens_siswa.detailsiswa_id', '=', 'detailsiswas.id')
            ->whereDate('eabsens_siswa.waktu_absen', now())
            ->groupBy('ekelas.id', 'ekelas.kelas')
            ->selectRaw('COUNT(eabsens_siswa.id) AS jumlah_absen')
            ->get();
    }

    public static function Absensi_Kelas()
    {
        return Ekelas::select('ekelas.kelas', 'ekelas.id')
            // ->selectRaw('COUNT(eabsens.detailsiswa_id) AS jumlah_absen')
            ->join('detailsiswas', 'detailsiswas.kelas_id', '=', 'ekelas.id')
            ->join('eabsens_siswa', 'eabsens_siswa.detailsiswa_id', '=', 'detailsiswas.id')
            ->whereDate('eabsens_siswa.waktu_absen', now()->toDateString())
            ->Where('ekelas.id', now()->toDateString())
            ->get();
    }
}

/*



php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

cls



php artisan migrate:fresh --seed


composer dump-autoload

*/