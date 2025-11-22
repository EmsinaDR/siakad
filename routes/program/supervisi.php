<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program/supervisi')->group(
    function () {
        Route::resource('instrument-supervisi', \App\Http\Controllers\Program\Supervisi\SupervisiInstrumentController::class);
        Route::resource('supervisi-pembelajaran', \App\Http\Controllers\Program\Supervisi\SupervisiPembelajaranController::class);
        Route::get('analisis-supervisi-pembelajaran', [\App\Http\Controllers\Program\Supervisi\SupervisiPembelajaranController::class, 'analisis'])->name('analisis-supervisi-pembelajaran');

        Route::resource('supervisi-perangkat-guru', \App\Http\Controllers\Program\Supervisi\SupervisiPerangkatGuruController::class);
        Route::resource('supervisi-atp-guru', \App\Http\Controllers\Program\Supervisi\SupervisiATPController::class);
        Route::resource('supervisi-modul-ajar-guru', \App\Http\Controllers\Program\Supervisi\SupervisiModulAjarController::class);

        Route::resource('supervisi-laboratorium', \App\Http\Controllers\Program\Supervisi\SupervisiLaboratoriumController::class);
        Route::resource('supervisi-laboran', \App\Http\Controllers\Program\Supervisi\SupervisiLaboranController::class);

        Route::resource('supervisi-wali-kelas', \App\Http\Controllers\Program\Supervisi\SupervisiWaliKelasController::class);
        Route::post('saran-supervisi-wali-kelas', [App\Http\Controllers\Program\Supervisi\SupervisiWaliKelasController::class, 'SaveSaranSupervisiWalkes'])->name('save.saran.supervisi');
        Route::resource('supervisi-perpustakaan', \App\Http\Controllers\Program\Supervisi\SupervisiPerpustakaanController::class);
        // php artisan make:custom-controller Program/Supervisi/Analisis/AnalisisiSupervisiWaliKelasController

        Route::resource('supervisi-waka-kurikulum', \App\Http\Controllers\Program\Supervisi\Waka\SupervisiWakaKurikulumController::class);
        Route::resource('supervisi-waka-kesiswaan', \App\Http\Controllers\Program\Supervisi\Waka\SupervisiWakaKesiswaanController::class);
        Route::resource('supervisi-waka-sarpras', \App\Http\Controllers\Program\Supervisi\Waka\SupervisiWakaSarprasController::class);

        Route::resource('jadwal-supervisi-perangkat', App\Http\Controllers\Program\SOP\DataSOPController::class);
        //Jadwal Supervisi
        //Jadwal Waka
        Route::resource('jadwal-supervisi-waka', \App\Http\Controllers\Program\Supervisi\Jadwal\JadwalSupervisiWakaController::class);
        Route::resource('jadwal-supervisi-guru', \App\Http\Controllers\Program\Supervisi\Jadwal\JadwalSupervisiGuruController::class);

        Route::resource('jadwal-supervisi-laboratorium', \App\Http\Controllers\Program\Supervisi\Jadwal\JadwalSupervisiLaboratoriumController::class);
        Route::resource('jadwal-supervisi-perpustakaan', \App\Http\Controllers\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaanController::class);

        //php artisan make:custom-controller Program/Supervisi/Jadwal/JadwalSupervisiGuruController
        Route::resource('jadwal-supervisi-kbm', App\Http\Controllers\Program\SOP\DataSOPController::class);
        // php artisan make:custom-controller Program/Supervisi/Analisis/AnalisisSupervisiPembelajaranController
        Route::resource('analisis-supervisi-wali-kelas', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiWaliKelasController::class); // Belum Proses
        Route::resource('analisis-supervisi-waka', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisiSupervisiWakaController::class); // Belum Proses
        Route::resource('analisis-supervisi-kbm', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiKbmController::class); // Belum Proses
        Route::resource('analisis-supervisi-modul-ajar', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiModulAjarController::class); // Belum Proses
        Route::resource('analisis-supervisi-laboratorium', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiLaboratoriumController::class); // Belum Proses
        Route::resource('analisis-supervisi-pembelajaran', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaranController::class); // Belum Proses
    }
);