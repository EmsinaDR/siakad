<?php

namespace Database\Seeders\AdminDev;

use App\Models\Admin\Identitas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataVendorSeeder extends Seeder
{
    public function run()
    {
        // TODO: tambahkan data seed di sini
        // Contoh:
        $Identitas = Identitas::first();
        DB::table('data_vendor')->insert([
            'token' => $Identitas->token,
            'paket' => $Identitas->paket,
            'trial_ends_at' => $Identitas->trial_ends_at,
            'nama_vendor' => 'Ata Digial',
            'alamat' => 'Jl. Makensi Banjarharjo Brebes',
            'kota' => 'Brebes',
            'provinsi' => 'Jawa Tengah',
            'kode_pos' => '52265',
            'tagline' => 'Melayani dengan data, Membimbing dengan digital',
            'kontak' => '625329860005',
            'telepon' => null,
            'fax' => null,
            'email' => 'danyroseptaata@gmail.com',
            'website' => null,
            'facebook_fanspage' => null,
            'facebook_user' => 'https://www.facebook.com/septa344347',
            'youtube' => null,
            'twiter' => null,
            'instagram' => null,
            'whatsap_komunitas' => null,
            'npwp' => null,
            'disk_secreet' => $Identitas->disk,
            'notes' => null,
            'status' => 'aktif',
            'github' => "
            https://github.com/EmsinaDR/siakad
            https://github.com/EmsinaDR/whatsapp
            ",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info("Seeder 'DataVendorSeeder' berhasil dijalankan.");
    }
}
