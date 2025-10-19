<?php

namespace App\Models\bk;

use Carbon\Carbon;
use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bkbimbingan extends Model
{
    //
    use HasFactory;
    protected $table = 'ebkbimbingans';
    protected $fillable = [
        'tapel_id',
        'tanggal',
        'detailguru_id',
        'detailsiswa_id',
        'permasalahan',
        'solusi',
        'proses',
    ];

    // Di model Bkbimbingan
    public function Siswa()
    {
        return $this->belongsTo(Detailsiswa::class, 'detailsiswa_id');
    }
    public function Guru()
    {
        return $this->belongsTo(Detailguru::class, 'detailguru_id');
    }

    public static function Save_WaBimbingan($pesan)
    {
        // Bimbingan /BK / DA/ NIS / Masalah
        $tapel = Etapel::where('aktiv', 'Y')->first();

        $DataPesan = explode('/', $pesan);
        $Data2 = $DataPesan[2] ?? ''; // Guru
        $Data3 = $DataPesan[3] ?? ''; // NIS
        $Data4 = $DataPesan[4] ?? ''; // Persmasalahan
        if (count($DataPesan) < 4) {
            return 'Pesan tidak valid atau format kurang lengkap.';
        }
        $Guru = Detailguru::where('kode_guru', $DataPesan[2])->first();
        $Siswaz = Detailsiswa::where('nis', $Data3)->first();
        if (!$Siswaz) {
            return 'Siswa Tidak Ditemukan';
        }

        $tanggal = now();
        $data = [
            'tapel_id' => $tapel->id,
            'detailsiswa_id' => $Siswaz->id,
            'detailguru_id' => $Guru->id,
            'permasalahan' => $Data4,
            'tanggal' => $tanggal,
            'proses' => 'Pending',
        ];

        // Simpan jika diperlukan
        self::create($data);
        HapusCacheDenganTag('dataBimbingan');
        $pesanKiriman = "Hallo {$Siswaz->nama_siswa} pesan sudah diterima, mohon tunggu konfirmasi lebih lanjut dari Bp/Ibu {$Guru->nama_guru}";
        return $pesanKiriman;
    }
}
