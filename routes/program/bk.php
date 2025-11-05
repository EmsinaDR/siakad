<?php

use Illuminate\Support\Facades\Route;

Route::prefix('bimbingan-konseling')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('bimbingan', App\Http\Controllers\bk\BkbimbinganController::class);
        Route::resource('bk-data-siswa', App\Http\Controllers\bk\EbkController::class);
        Route::resource('kredit-point', App\Http\Controllers\bk\EbkkreditpointController::class);
        Route::resource('pelanggaran', App\Http\Controllers\bk\EbkpelanggaranController::class);
        Route::POST('upload-pelanggaran', [App\Http\Controllers\bk\EbkpelanggaranController::class, 'uploadkreditpoint'])->name('uploadkreditpoint');
        Route::resource('pengaduan', App\Http\Controllers\bk\EbkpelanggaranController::class);
        Route::GET('bk-surat', [App\Http\Controllers\Dokumen\Surat\SuratController::class, 'surat_bk'])->name('surat_bk'); //controllernya apa
        Route::GET('panggilan', [App\Http\Controllers\Dokumen\Surat\SuratController::class, 's_panggilan'])->name('s_panggilan');
        Route::GET('surat-ijin-km', [App\Http\Controllers\Dokumen\Surat\SuratController::class, 's_ijin'])->name('s_ijin');
        Route::resource('surat', App\Http\Controllers\Bendahara\BendaharaDaftarUlangController::class);
        // Quesuiner
        Route::resource('dasboard-quesioner', \App\Http\Controllers\Program\Quesioner\DasboardQuesionerController::class);
        Route::resource('pertanyaan-quesioner', \App\Http\Controllers\Program\Quesioner\DataPertanyaanQuesionerController::class);
        Route::resource('jawaban-quesioner', \App\Http\Controllers\Program\Quesioner\JawabnQuesionerController::class)->middleware(['auth', 'verified']);
        // php artisan make:custom-controller Program/Quesioner/JawabnQuesionerController tapel_id/detailsiswa_id/pertanyaan_id,jawaban
        // Route::resource('url', \App\Http\Controllers\Folder\NameController::class)->middleware(['auth', 'verified']);
    }
);