<?php

use App\Models\Admin\Etapel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Whatsapp\WhatsApp;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Siswa\Detailsiswa;

/*
        |--------------------------------------------------------------------------
        | 📌 DataSekolahHelper :
        |--------------------------------------------------------------------------
        |
        | Fitur :
        | - xxxxxxxxxxx
        | - xxxxxxxxxxx
        |
        | Tujuan :
        | - xxxxxxxxxxx
        |
        | Penggunaan :
        | - xxxxxxxxxxx
        |
    */

// Proses Coding
if (!function_exists('tapel')) {
    /**
     * Ambil Tahun Pelajaran (Etapel) yang aktif
     *
     * @return \App\Models\Etapel|null
     *
     * Contoh penggunaan:
     *
     *
     */
    /*
        $tapel = getEtapelAktif();
        echo $tapel->nama_tapel;
    */
    function tapel()
    {
        return Etapel::where('aktiv', 'Y')->first();
    }
}
