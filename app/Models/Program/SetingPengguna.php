<?php

namespace App\Models\Program;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;

class SetingPengguna extends Model
{
    //
    protected $table = 'program';
    protected $fillable = [
        'nama_program',
        'detailguru_id',


    ];
    public function Guru()
    {
        return $this->hasOne(Detailguru::class, 'id', 'detailguru_id');
    }
    public function isGuruTerlibat($userId)
    {
        $ids = is_array($this->detailguru_id)
            ? $this->detailguru_id
            : json_decode($this->detailguru_id, true) ?? [];

        return collect($ids)->contains($userId);
    }
    public function Tapels()
    {
        return $this->hasOne(Etapel::class, 'id', 'tapel_id');
    }
}
