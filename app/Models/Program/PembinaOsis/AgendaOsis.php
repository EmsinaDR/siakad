<?php

namespace App\Models\Program\PembinaOsis;

use App\Models\Admin\Etapel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaOsis extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'tapel_id',
        'nama_kegiatan',
        'tanggal_kegiatan',
        'jumlah_peserta',
        'tujuan_kegiatan',
        'lokasi_kegiatan',
        'keterangan',
        'status_kegiatan',
        'dokumentasi_url',
        'anggaran',
    ];

    protected $table = 'agenda_osis';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Tapel()
    {
       return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
}
