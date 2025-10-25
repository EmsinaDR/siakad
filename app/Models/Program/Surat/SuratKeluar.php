<?php

namespace App\Models\Program\Surat;

use App\Models\Admin\Identitas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'tapel_id',
        'klasifikasi_id',
        'nomor_surat',
        'surat_masuk_id',
        'tanggal_surat',
        'tujuan',
        'perihal',
        'lampiran',
        'keterangan',
        'variabel',
        'template_id',
    ];

    protected $table = 'surat_keluar';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Klasifikasi()
    {
        return $this->hasOne(SuratKlasifikasi::class, 'id', 'klasifikasi_id');
    }
    public static function DataNoSurat($kalsifikasiId)
    {
        //dd($request->all());
        $Klasifikasi = SuratKlasifikasi::find($kalsifikasiId);
        $JumlahSurat = SuratKeluar::count();
        $JumlahSuratId = SuratKeluar::where('klasifikasi_id', $kalsifikasiId)->count();
        $Identitas = Identitas::first();
        $kode = str_pad($JumlahSuratId, 3, '0', STR_PAD_LEFT);
        $JmlahSurat = str_pad($JumlahSurat, 3, '0', STR_PAD_LEFT);
        $kodeSurat = $JmlahSurat . '/' . $Identitas->KodeSingkat() . '/' . $Klasifikasi->kode . '.' . $kode . '/' . date('m') . '/' . date('Y');
        return $kodeSurat;
    }
    // app/Models/SuratKeluar.php

    public static function generateNoSurat($klasifikasiId)
    {
        $klasifikasi = SuratKlasifikasi::find($klasifikasiId);

        if (!$klasifikasi) {
            return null; // atau throw exception kalau mau
        }

        $kode = $klasifikasi->kode ?? 'XX';
        $totalSurat = self::count();
        $urutPerKlasifikasi = self::where('klasifikasi_id', $klasifikasiId)->count() + 1;
        $urutPerKlasifikasi = str_pad($urutPerKlasifikasi, 2, '0', STR_PAD_LEFT);
        $JmlSuratTotal = str_pad($totalSurat, 3, '0', STR_PAD_LEFT);
        $bulan = now()->format('m');
        $romawi = ['I', 'II', 'III', 'IV', 'V', 'VI','VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $bulanRum = $romawi[intval($bulan) - 1];
        $tahun = now()->format('Y');

        $identitas = Identitas::first(); // bisa where('aktif', 1)
        $SingkatanSekolah = $identitas ? $identitas->KodeSingkat() : 'XX000';

        $noSurat = strtoupper("{$JmlSuratTotal}/{$kode}.{$urutPerKlasifikasi}/{$SingkatanSekolah}/{$bulanRum}/{$tahun}");

        return $noSurat;
    }
}
