<?php

namespace App\Models\WakaSarpras\Inventaris;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    //
    protected $table = 'inventaris';

    protected $fillable = ['kode', 'nama_barang', 'kategori', 'sub_kategori', 'keterangan', 'system'];
    /*

      $table->increments('id');
            $table->string('kode')->nullable();
            $table->string('system')->nullable();
            $table->string('nama_barang')->nullable();
            $table->string('kategori')->nullable();
            $table->string('sub_kategori')->nullable();
            $table->longText('keterangan')->nullable();

            */
}
