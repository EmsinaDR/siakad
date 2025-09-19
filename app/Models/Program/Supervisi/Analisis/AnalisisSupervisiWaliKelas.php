<?php

namespace App\Models\Program\Supervisi\Analisis;

use App\Models\Admin\Ekelas;
use App\Models\Program\Supervisi\SupervisiInstrument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisSupervisiWaliKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        // Tentukan field yang bisa diisi
    ];
    //supervisi_wali_kelas
    // protected $table = 'analisis_supervisi_wali_kelas';  // Misalkan model ini menggunakan nama tabel khusus
    protected $table = 'supervisi_wali_kelas';  //

    protected $primaryKey = 'id';  // Sesuaikan dengan primary key yang kamu gunakan

    // Tambahkan relasi atau metode lain jika diperlukan
    public function Indikator()
    {
       return $this->hasOne(SupervisiInstrument::class, 'id', 'indikator_id');
    }
    public function kelas()
    {
       return $this->hasOne(Ekelas::class, 'id', 'kelas_id');
    }
}
