<?php

namespace App\Models\User\Guru;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Ekaldik;
use App\Models\Program\CBT\BankSoal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\WakaKurikulum\Perangkat\JadwalTest;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detailguru extends Model
{
    use HasFactory;
    protected $table = "detailgurus";
    protected $fillable = [
        'user_id',
        'kelas_id',
        'foto',
        'kode_guru',
        'nama_guru',
        'gelar',
        'nip',
        'nuptk',
        'nik',
        'status',
        'tahun_sertifikasi',
        'jenis_kelamin',
        'pendidikan',
        'lulusan',
        'jurusan',
        'tahun_lulus',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'jalan',
        'alamat',
        'no_hp',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'tmt_mengajar',
    ];

    public function Kaldik(): BelongsTo
    {

        return $this->BelongsTo(Ekaldik::class, 'kaldik_id');
    }
    public function DetailguruUsers(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'detailguru_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jadwalTests()
    {
        return $this->hasMany(\App\Models\WakaKurikulum\Perangkat\JadwalTest::class, 'detailguru_id');
    }
    public function bankSoals()
    {
        return $this->hasMany(BankSoal::class);
    }

    public function generateDataGuru(): array
    {
        return [
            '{{nama_guru}}' => $this->nama_guru,
            '{{nip_guru}}' => $this->nip_guru,
            '{{alamat_guru}}' => $this->alamat_guru,
            '{{kode_guru}}' => $this->kode_guru,
            '{{status_guru}}' => $this->status_guru,
            '{{no_hp}}' => $this->no_hp,
        ];
    }
}
