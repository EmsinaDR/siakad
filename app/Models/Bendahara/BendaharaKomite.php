<?php

namespace App\Models\Bendahara;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use App\Models\User\Siswa\Detailsiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BendaharaKomite extends Model
{
    //
    protected $table = 'keuangan_komite';
    protected $fillable = [
        'tapel_id',
        'semester',
        'tingkat_id',
        'singkatan',
        'nomor_pembayaran',
        'pembayaran_id',
        'detailsiswa_id',
        'tingkat_id',
        'kelas_id',
        'petugas_id',
        'nominal',
        'keterangan'

    ];
    public function BendaharaKomiteToDetailsiswa(): HasOne
    {
        // return this->hasOne(DetailSiswa::class);
        return $this->hasOne(Detailsiswa::class, 'id', 'detailsiswa_id');;
    }
    public function BendaharaKomiToDetailgurus(): HasOne
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
}
