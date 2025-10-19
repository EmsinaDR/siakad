<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Identitas extends Model
{
    use HasFactory;

    // Menambahkan kolom yang dapat diisi secara massal
    protected $fillable = [
        'jenjang',
        'nomor',
        'kode_sekolahan',
        'kode_kabupaten',
        'kode_provinsi',
        'namasingkat',
        'namasek',
        'nsm',
        'npsn',
        'status',
        'akreditasi',
        'alamat',
        'logo',
        'phone',
        'email',
        'desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'kode_pos',
        'namakepala',
        'nip_kepala',
        'visi',
        'misi',
        'tujuan',
        'website',
        'facebook',
        'facebook_fanspage',
        'facebook_group',
        'twiter',
        'instagram',
        'whatsap_grou_guru',
        'whatsap_grou_siswa',
        'internet',
        'speed',
        'paket',
    ];


    public function KodeSingkat()
    {
        // Hapus spasi dari jenjang
        $jenjang = str_replace(' ', '', $this->jenjang);

        // Pastikan nomor tidak null untuk menghindari error
        $nomor = $this->nomor ?? '000';

        // Gabungkan jenjang dan nomor
        return "{$jenjang}{$nomor}";
    }

}
