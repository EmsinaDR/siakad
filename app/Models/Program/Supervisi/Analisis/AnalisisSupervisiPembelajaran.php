<?php

namespace App\Models\Program\Supervisi\Analisis;

use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program\Supervisi\SupervisiInstrument;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnalisisSupervisiPembelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
    ];

    // protected $table = 'analisis_supervisi_pembelajaran';  // Misalkan model ini menggunakan nama tabel khusus
    protected $table = 'supervisi_pembelajaran';  // Misalkan model ini menggunakan nama tabel khusus

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function indikator()
    {
        return $this->hasOne(SupervisiInstrument::class, 'id', 'indikator_id');
    }
    public function supervisiInstrument()
    {
        return $this->hasOne(SupervisiInstrument::class, 'id', 'indikator_id');
    }
    public function Mapel()
    {
        return $this->hasOne(Emapel::class, 'id', 'mapel_id');
    }
    public function Kelas()
    {
        return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
