<?php

namespace App\Models\Registrasi;

use Illuminate\Database\Eloquent\Model;

class RegistrasiSekolah extends Model
{
    //
    protected $table = 'identitas';
    protected $fillable = [
        'regis',
        'paket',
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
        'visi',
        'misi',
        'tujuan',
        'website',
        'facebook',
        'facebook_fanspage',
        'facebook_group',
        'twiter',
        'instagram',
        'whatsap_group',
        'internet',
        'speed',
    ];
}
