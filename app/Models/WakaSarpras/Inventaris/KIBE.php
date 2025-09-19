<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Model;

class KIBE extends Model
{

    protected $table = 'inventaris_kibe';
    protected $fillable = [
            'field_one',
            'field_two',


        ];
    public function Inventaris()
    {
       return $this->hasOne(Inventaris::class, 'id', 'barang_id');
    }
    public function Vendor()
    {
       return $this->hasOne(InventarisVendor::class, 'id', 'vendor_id');
    }
}
