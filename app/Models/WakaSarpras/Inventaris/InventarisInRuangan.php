<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Model;
use App\Models\Laboratorium\Elaboratorium;
use App\Models\WakaSarpras\Inventaris\KIBA;
use App\Models\WakaSarpras\Inventaris\KIBB;
use App\Models\WakaSarpras\Inventaris\KIBC;
use App\Models\WakaSarpras\Inventaris\Inventaris;

class InventarisInRuangan extends Model
{
    //
    protected $table = 'inventaris_in_ruangan';
    protected $fillable = [
        'inventaris_id',
        'inventaris_id',
        'baik',
        'rusak',
        'jumlah',
        'kibb_id',
        'kibc_id',
    ];
    public function DataKIBC()
    {
        return $this->hasOne(KIBC::class, 'id', 'kibc_id');
    }
    public function DataKIBB()
    {
        return $this->hasOne(KIBB::class, 'id', 'kibb_id');
    }
    public function DataInventaris()
    {
        return $this->hasOne(Inventaris::class, 'id', 'inventaris');
    }
    // public function DataLaboratorium()
    // {
    //    return $this->hasOne(Elaboratorium::class, 'id', 'filed_id');
    // }
}
