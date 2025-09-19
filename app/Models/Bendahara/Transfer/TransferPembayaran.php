<?php

namespace App\Models\Bendahara\Transfer;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\Bendahara\KeuanganRiwayatList;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
        'petugas_id',
        'tapel_id',
        'semester',
        'nomor_pembayaran',
        'pembayaran_id',
        'detailsiswa_id',
        'tingkat_id',
        'kelas_id',
        'nominal',
        'status',
        'transaksi',
        'lock',
        'keterangan',
        'sumber_dana',
    ];

    protected $table = 'transfer_pembayaran';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Siswa()
    {
        // return this->hasOne(DetailSiswa::class);
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');;
    }
    public function BendaharaKomiToDetailgurus()
    {
        // return this->hasOne(Detailguru::class);
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function BendaharaKomiteToEtapel()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
    public function BendaharaKomiteToKelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
    public function KeuanganRiwayat()
    {
        return $this->hasOne(KeuanganRiwayatList::class, 'id', 'pembayaran_id');
    }
    public function GuruPerantara()
    {
       return $this->hasOne(Detailguru::class, 'id', 'petugas_id');
    }
}
