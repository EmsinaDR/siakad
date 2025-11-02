<?php

namespace App\Models\AdminDev;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSekolahSMP extends Model
{
    use HasFactory;

    protected $fillable = [
        'ceklist',
        'tingkat',
        'tanggal_kunjungan',
        'nsm',
        'npsn',
        'akreditasi',
        'nama_sekolah',
        'alamat',
        'kecamatan',
        'kelurahan',
        'status',
        'siswa_l',
        'siswa_p',
        'nama_kepala',
        'nohp_kepala',
        'nama_operator',
        'link_reference',
        'link_data',
        'keterangan',
    ];


    protected $table = 'data_sekolah_s_m_p';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
}
