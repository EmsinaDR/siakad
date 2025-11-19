<?php

use Illuminate\Support\Facades\Route;

Route::prefix('elearning/{mapel_id}/{semester}/{tingkat_id}/{kelas_id}')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('data-materi', App\Http\Controllers\Learning\EmateriController::class);
        Route::resource('data-tugas', App\Http\Controllers\Learning\EtugasController::class);
        Route::GET('etugas-siswa', [App\Http\Controllers\Learning\EtugasController::class, 'etugassiswa'])->name('etugassiswa');

        //KKM
        //Enilai
        Route::prefix('nilai')->group(function () {
            Route::resource('/nilai-tugas', App\Http\Controllers\Learning\EnilaiTugasController::class);
            // Route::resource('/data-nilai-tugas', EnilaiTugasController::class);
            Route::GET('/data-nilai-tugas', [App\Http\Controllers\Learning\EnilaiTugasController::class, 'DS_generatsiswa'])->name('DS-generatsiswa.index');
            Route::POST('data-nilai-all-tugas', [App\Http\Controllers\Learning\EnilaiTugasController::class, 'upadaAllIn_tugas'])->name('upadaAllIn-tugas.update');

            Route::resource('/nilai-ulangan', App\Http\Controllers\Learning\EnilaiUlanganController::class);
            Route::GET('/data-nilai-ulangan', [App\Http\Controllers\Learning\EnilaiUlanganController::class, 'DS_generatsiswa'])->name('DS-generatsiswa.index');
            Route::POST('data-nilai-all-ulangan', [App\Http\Controllers\Learning\EnilaiUlanganController::class, 'upadaAllIn'])->name('upadaAllIn-ulangan.update');
            Route::resource('/nilai-pts-pas', App\Http\Controllers\Learning\EnilaiPtsPasController::class);
            Route::resource('/enilai', App\Http\Controllers\Learning\EnilaiController::class);
        });
        //Jurnal
        Route::prefix('jurnal')->group(function () {
            Route::resource('/ejurnalmengajar', App\Http\Controllers\Learning\JurnalmengajarController::class);
            // Route::resource('/ejurnalmengajar/{id}', JurnalmengajarController::class);
            // Route::GET('/ejurnalmengajar/{token}/{mapel_id}/{semester}/{tingkat_id}/{kelas_id}/{hidden}', [JurnalmengajarController::class, 'ejurnalmengajarkelas'])->name('ejurnalmengajarkelas');
            Route::GET('/ejurnalmengajar/{id}', [App\Http\Controllers\Learning\JurnalmengajarController::class, 'destroy'])->name('ejurnalmengajar.destroy');
            Route::PATCH('/ejurnalmengajar/{id}', [App\Http\Controllers\Learning\JurnalmengajarController::class, 'update'])->name('ejurnalmengajar.update');
        });
    }
);
