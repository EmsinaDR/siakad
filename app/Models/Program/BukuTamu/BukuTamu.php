<?php

namespace App\Models\Program\BukuTamu;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BukuTamu extends Model
{
    use HasFactory;

    protected $table = 'buku_tamu';

    protected $fillable = [
        'nama',
        'nomor_surat',
        'file',
        'instansi',
        'keperluan',
        'kontak',
        'waktu_kedatangan',
        'waktu_kepergian',
        'catatan',
        'detailguru_id',
        'tapel_id',
    ];
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
/*
            'nama' => 'required|string|max:255',
            'nomor_surat' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'instansi' => 'nullable|string|max:255',
            'keperluan' => 'required|string|max:500',
            'kontak' => 'nullable|string|max:20',
            'waktu_kedatangan' => 'nullable|date',
            'waktu_kepergian' => 'nullable|date|after_or_equal:waktu_kedatangan',
            'catatan' => 'nullable|string',





*/