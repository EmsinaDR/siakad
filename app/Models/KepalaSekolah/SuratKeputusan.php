<?php

namespace App\Models\KepalaSekolah;

use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class SuratKeputusan extends Model
{
    //
    protected $table = 'surat_keputusan';
    protected $fillable = [
        'nomor_sk',          // Nomor surat keputusan
        'nama_sk',           // Nama SK
        'tanggal_sk',        // Tanggal SK
        'pejabat_penerbit',  // Nama pejabat penerbit
        'perihal',           // Perihal SK
        'content_system',    // Isi SK sistem
        'content_sekolah',   // Isi SK sekolah
        'deskripsi',         // Deskripsi SK
        'file_path',         // Path file SK di storage
        'file_name',         // Nama asli file SK
        'template_id',         // Hubungan dengan TemplateDokumen
        'detailguru_id',         // Hubungan dengan TemplateDokumen
    ];
    public function Guru()
    {
       return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
}
