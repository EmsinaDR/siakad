<?php

namespace App\Models\Absensi;

use App\Models\Admin\Etapel;
use App\Models\Whatsapp\WhatsApp;
use App\Models\Whatsapp\WhatsappLog;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataIjinDigital extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'tapel_id',
        'detailsiswa_id',
        'ijin',
        'keterangan'
    ];

    protected $table = 'data_ijin_digital';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    public function Siswa()
    {
        return $this->belongsTo(Detailsiswa::class, 'detailsiswa_id');
    }

    // Tambahkan relasi atau metode lain jika diperlukan
    public static function createByWa($nohp, $pesan) // Untuk create di Whatsapp GateWay
    {
        // Contoh format pesan: NOHP/IDSISWA/IJIN/KETERANGAN
        // ini yang diminta : IDSISWA/IJIN/KETERANGAN
        // ini yang diminta : Ijin Siswa / Siswa / 2025001 / Ijin / Keterangan
        $Tapels = Etapel::where('aktiv', 'Y')->first();
        $DataPesan = explode('/', $pesan);
        $sessions = config('whatsappSession.IdWaUtama');

        if (count($DataPesan) < 5) {
            return WhatsApp::sendMessage($sessions, $nohp, '⚠️ Format pesan tidak valid. Gunakan format: Ijin Siswa/Siswa/NIS/Ijin/Keterangan');
        }
        $part0 = $DataPesan[0] ?? ''; // Ijin Siswa
        $part1 = $DataPesan[1] ?? ''; // Siswa
        $part2 = $DataPesan[2] ?? ''; // 2025001
        $part3 = $DataPesan[3] ?? ''; // ijin,sa kit atau alfa
        $part4 = $DataPesan[4] ?? ''; // Keterangan

        // Optional: Validasi ID siswa
        $siswa = Detailsiswa::where('nis', $part2)->first();
        if (!$siswa) {
            return WhatsApp::sendMessage($sessions, $nohp,  '⛔ Siswa tidak tidak terdaftar di database');
        }
        // Optional: Validasi bahwa $nohp = ayah_nohp atau ibu_nohp
        // if ($nohp !== $siswa->ayah_nohp && $nohp !== $siswa->ibu_nohp) {
        //     return WhatsApp::sendMessage($sessions, $nohp,  'No tidak terdaftar di dalam sistem yang diverifikasi'); // Atau log "No HP tidak cocok dengan orang tua"
        // }
        // Cek duplikat data hari ini
        $cekDuplikat = self::where('detailsiswa_id', $siswa->id)
            ->whereDate('created_at', now()->toDateString())
            ->where('ijin', $part3)
            ->first();
        $cekDuplikat = self::where('detailsiswa_id', $siswa->id)
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if ($cekDuplikat) {
            return WhatsApp::sendMessage($sessions, $nohp, '⛔ Ijin siswa hari ini sudah tercatat dalam database. Tidak perlu mengirim ulang.');
        }

        // Simpan data ⛔ ⚠️
        $data = self::create([
            'tapel_id' => $Tapels->id,
            'detailsiswa_id' => $siswa->id,
            'ijin' => $part3,
            'keterangan' => $part4,
        ]);
        WhatsappLog::LogWhatsapp($nohp, $pesan);
        $result = \App\Models\Whatsapp\WhatsApp::sendMessage($sessions, $nohp,  'Proses ijin siswa telah disimpan di database akan segera di proses dan di validasi guru piket / petugas');
        return $data;
    }
}
