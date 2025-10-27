<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Model;

class KIBD extends Model
{

    protected $table = 'inventaris_kibd';
    protected $fillable = [
        'barang_id',
        'nama_proyek',
        'vendor_id',
        'volum_pekerjaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'estimasi_anggaran',
        'lokasi',
        'keterangan_proyek',
    ];
    public function Vendor()
    {
       return $this->hasOne(InventarisVendor::class, 'id', 'vendor_id');
    }

}

//  'barang_id' => 'nullable|integer|exists:barangs,id',
//             'nama_proyek' => 'nullable|string|max:255',
//             'vendor_id' => 'nullable|integer|exists:vendors,id',
//             'volum_pekerjaan' => 'nullable|string|max:255',
//             'tanggal_mulai' => 'nullable|date|before_or_equal:tanggal_selesai',
//             'tanggal' => 'nullable|date|after_or_equal:tanggal_mulai',
//             'status_pengerjaan' => 'nullable|integer|between:0,100', // Misalnya 0-100 persen
//             'lokasi' => 'nullable|string|max:255',