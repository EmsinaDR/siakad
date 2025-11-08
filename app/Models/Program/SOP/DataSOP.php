<?php

namespace App\Models\Program\SOP;

use Illuminate\Database\Eloquent\Model;

class DataSOP extends Model
{
    //
    protected $table = 'data_sop';
    protected $fillable = [
        'bidang',
        'kategori',
        'judul',
        'dasar_hukum',
        'kualifikasi_pelaksana',
        'keterkaitan',
        'peralatan',
        'peringatan',
        'pencatatan',
        'keterangan',
        'tanggal_pembuatan',
        'tanggal_revisi',
        'tanggal_pengesahan',
    ];
}
