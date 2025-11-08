<?php

namespace App\Models\WakaKesiswaan\PPDB;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class PPDBPeserta extends Model
{
    // use HasFactory;
    
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
    public function pengumumanPPDB()
    {
        return $this->hasOne(PengumumanPPDB::class, 'calon_id', 'id');
    }

    public function pembayaranPPDB()
    {
        return $this->hasManyThrough(
            PembayaranPPDB::class,  // Model tujuan (pembayaran)
            PengumumanPPDB::class,  // Model perantara (pengumuman)
            'calon_id',           // Foreign key di `pengumuman_ppdb` yang mengacu ke `ppdb_peserta`
            'pengumuman_id',        // Foreign key di `ppdb_pembayaran` yang mengacu ke `pengumuman_ppdb`
            'id',                   // Primary key di `ppdb_peserta`
            'id'                    // Primary key di `pengumuman_ppdb`
        );
    }
}
