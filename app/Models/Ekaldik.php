<?php

namespace App\Models;

use App\Models\Admin\Etapel;
use App\Models\User\Guru\Detailguru;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ekaldik extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'kategori',
        'tgl_awal',
        'tgl_akhir',
        'kegiatan',
        'tujuan',
        'indikator_pecapaian',
        'rencana_anggaran',
        'status',
        'catatan',
        'penanggung_jawab',
        'created_at',
        'updated_at',
        'updated_at',
    ];
    // protected $fillable = [
    //     'judul',
    //     'body',
    //     'user_id',
    //     'slug',
    //     'cat_id',
    //     'updated_at',
    //     'created_at',

    // ];
    // protected function casts(): array
    // {
    //     return [
    //         'penanggung_jawab' => AsArrayObject::class,
    //         // 'penanggung_jawab' => AsCollection::class,
    //     ];
    // }
    protected $casts = [
        'penanggung_jawab' => 'array',
    ];
    public function KaldikTapel(): BelongsTo
    {
        return $this->BelongsTo(Etapel::class, 'id');
    }
    public function Userkaldik(): BelongsTo
    {
        return $this->BelongsTo(Detailguru::class, 'user_id');
    }
}
