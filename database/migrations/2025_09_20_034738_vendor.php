<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('data_vendor', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('token')->nullable();
            $table->string('paket')->nullable();
            $table->string('trial_ends_at')->nullable();
            $table->string('nama_vendor')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('tagline')->nullable();
            $table->string('kontak')->nullable();
            $table->string('telepon')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_fanspage')->nullable();
            $table->string('facebook_user')->nullable();
            $table->string('youtube')->nullable();
            $table->string('twiter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('whatsap_komunitas')->nullable();
            $table->longText('github')->nullable();
            $table->string('npwp')->nullable();
            $table->string('disk_secreet')->nullable();
            $table->longText('notes')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            // Foreign key opsional jika ada tabel users
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
/*

id
token
paket
trial_ends_at
nama_vendor
alamat
kota
provinsi
kode_pos
tagline
kontak
telepon
fax
email
website
facebook_fanspage
facebook_user
youtube
twiter
instagram
whatsap_komunitas
npwp
disk_secreet
notes
status
created_by
updated_by



*/