<?php

namespace App\Models\WakaKesiswaan\PPDB;

use App\Models\Admin\Etapel;
use Illuminate\Support\Facades\DB;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendaftaranPPDB extends Model
{
    //

    protected $table = 'ppdb_peserta';
    protected $fillable = [
        'status_penerimaan',
        'nomor_peserta',
        'detailguru_id',
        'jalur',
        'rekomendasi',
        'foto',
        'nama_calon',
        'nisn',
        'nik',
        'nokk',
        'hobi',
        'cita_cita',
        'agama',
        'nohp_calon',
        'jml_saudara',
        'jenis_kelamin',
        'anak_ke',
        'status_anak',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat_calon',
        'rt',
        'rw',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'jalan',
        'namasek_asal',
        'alamatsek_asal',
        'nama_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nohp_ayah',
        'alamat_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nohp_ibu',
        'alamat_ibu',
        'kk',
        'akta_kelahiran',
        'ktp_ayah',
        'ktp_ibu',
        'ijazah',
        'surat_keterangan_lulus',
        'kartu_kia',
        'kartu_nisn',
        'kartu_bantuan_1',
        'kartu_bantuan_2',
        'kartu_bantuan_3',
        'kartu_bantuan_4',
        'kartu_bantuan_5',
    ];

    protected $dates = ['tanggal_lahir'];

    public function detailGuru()
    {
        return $this->belongsTo(Detailguru::class, 'detailguru_id');
    }
    public function Tahun()
    {
       return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
    public function getTrenPenerimaanAttribute()
    {
        // Ambil tapel_id yang aktif saat ini dari tabel Etapel
        $etapels = Etapel::where('aktiv', 'Y')->first();

        if (!$etapels) {
            return "Data Etapel tidak ditemukan";
        }

        $tapelSaatIni = $etapels->id; // Ambil tapel_id yang aktif

        // Ambil 3 tahun terakhir yang ada di database
        $recentTapel = self::select('tapel_id')
            ->distinct()
            ->where('tapel_id', '<=', $tapelSaatIni)
            ->orderBy('tapel_id', 'DESC') // DESC agar terbaru di atas
            ->limit(3) // Ambil 3 tahun terbaru yang ada di database
            ->pluck('tapel_id')
            ->toArray();

        if (count($recentTapel) < 3) {
            return "Data tidak cukup untuk analisis";
        }

        // Ambil jumlah diterima berdasarkan tapel_id
        $dataPenerimaan = self::select(
            'tapel_id',
            DB::raw("SUM(CASE WHEN status_penerimaan = 'Diterima' THEN 1 ELSE 0 END) as jumlah_diterima")
        )
            ->whereIn('tapel_id', $recentTapel)
            ->groupBy('tapel_id')
            ->orderBy('tapel_id', 'DESC') // Tetap DESC agar tahun terbaru di atas
            ->get();

        // Format data menjadi array [tapel_id => jumlah_diterima]
        $penerimaan = $dataPenerimaan->pluck('jumlah_diterima', 'tapel_id')->toArray();

        // Pastikan array memiliki 3 elemen (jika kurang, tambahkan dengan 0)
        while (count($penerimaan) < 3) {
            $missingYear = min(array_keys($penerimaan)) - 1;
            $penerimaan[$missingYear] = 0;
        }

        // Urutkan kembali agar tetap dalam DESC (2025 → 2024 → 2023)
        krsort($penerimaan);

        // Dapatkan tahun terlama untuk diberikan "N/A"
        $tahun_terlama = array_key_last($penerimaan);

        // Hitung tren naik/turun dengan urutan yang benar
        $tren = [];
        $penerimaan_values = array_values($penerimaan); // Ambil nilai tanpa key
        $penerimaan_keys = array_keys($penerimaan); // Simpan tahun dalam array

        for ($i = 0; $i < count($penerimaan_keys); $i++) {
            $year = $penerimaan_keys[$i];
            $accepted = $penerimaan_values[$i];

            if ($year === $tahun_terlama) {
                // Tahun terlama harus N/A
                $tren[$year] = [
                    'jumlah_diterima' => $accepted,
                    'perubahan' => null,
                    'persentase_perubahan' => "N/A",
                ];
            } else {
                $prevAccepted = $penerimaan_values[$i + 1] ?? 0; // Pastikan tidak error jika tidak ada nilai sebelumnya

                $change = $accepted - $prevAccepted;
                $percentageChange = $prevAccepted > 0 ? ($change / $prevAccepted) * 100 : 0;

                $tren[$year] = [
                    'jumlah_diterima' => $accepted,
                    'perubahan' => $change,
                    'persentase_perubahan' => round($percentageChange, 2) . "%",
                ];
            }
        }

        return $tren;
    }

    /**
     * Ambil data pendaftaran per sekolah dalam 3 tapel terakhir berdasarkan tapel aktif.
     */
    public static function getPivotData()
    {
        $datas = self::select(
                'namasek_asal',
                'tapel_id',
                DB::raw('COUNT(*) as total_siswa')
            )
            ->groupBy('namasek_asal', 'tapel_id')
            ->orderBy('namasek_asal', 'DESC')
            ->get();

        // Format data menjadi pivot
        $pivotData = [];
        $years = [];

        foreach ($datas as $data) {
            $pivotData[$data->namasek_asal][$data->tapel_id] = $data->total_siswa;
            $years[$data->tapel_id] = $data->tapel_id; // Mengumpulkan tahun unik
        }

        sort($years); // Mengurutkan tahun agar rapi

        return ['pivotData' => $pivotData, 'years' => $years];
    }
}
