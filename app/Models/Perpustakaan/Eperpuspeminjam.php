<?php

namespace App\Models\Perpustakaan;

use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use App\Models\Perpustakaan\Eperpuskatalog;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Eperpuspeminjam extends Model
{
    use HasFactory;
    protected $table = 'perpustakaan_peminjaman';
    protected $fillable = [
        'detailsiswa_id',
        'buku_id',
        'kategori_id',
        'tanggal_peminjaman',
        'batas_pengembalian',
        'tanggal_pengembalian',
        'status',
        'keterangan',
    ];
    protected $casts = [
        'tanggal_peminjaman' => 'datetime',
        'batas_pengembalian' => 'datetime',
        'tanggal_pengembalian' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Detailsiswa::class, 'detailsiswa_id');
    }

    public function siswatoBel()
    {
        return $this->belongsTo(Detailsiswa::class, 'detailsiswa_id', 'id');
    }
    public function buku()
    {
        return $this->belongsTo(Eperpuskatalog::class, 'buku_id');
    }

    public function kategoriBuku()
    {
        return $this->hasOneThrough(PerpustakaanKategoriBuku::class, Eperpuskatalog::class, 'id', 'id', 'buku_id', 'kategori_id');
    }



    public function kategori()
    {
        return $this->belongsTo(PerpustakaanKategoriBuku::class, 'kategori_id');
    }
    /*
$.each(response, function(index, data) {
    table.row.add([
        data.id ?? 'N/A', // Kolom 1 - ID Peminjam
        data.siswa?.nis ?? 'Tidak ada NIS', // Kolom 2 - NIS
        data.buku?.judul_buku ?? 'Tidak ada Buku', // Kolom 3 - Judul Buku
        data.kategori_buku?.nama_kategori ?? 'Tidak ada Nama', // Kolom 4 - Nama Kategori
        data.status ?? 'Belum ada status' // Kolom 5 - Status
    ]).draw();
});




    */
}
