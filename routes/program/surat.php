<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program')->group(function () {
    // Tambahkan route modul di sini
    // Surat
    Route::resource('surat', App\Http\Controllers\Dokumen\Surat\SuratController::class)->middleware(['auth', 'verified']);
    Route::resource('klasifikasi-surat', \App\Http\Controllers\Program\Surat\SuratKlasifikasiController::class)->middleware(['auth', 'verified']);
    Route::resource('surat-masuk', \App\Http\Controllers\Program\Surat\SuratMasukController::class)->middleware(['auth', 'verified']);
    Route::resource('surat-keluar', \App\Http\Controllers\Program\Surat\SuratKeluarController::class)->middleware(['auth', 'verified']);
    Route::post('surat-keluar-save', [\App\Http\Controllers\Program\Surat\SuratKeluarController::class, 'SuratKeluarSave'])->name('surat.keluar.save')->middleware(['auth', 'verified']);
    Route::get('surat-aktif-whatsapp', [\App\Http\Controllers\Program\Surat\SuratKeluarController::class, 'suratAktifWhatsapp'])->name('surat.aktif.whatsapp')->middleware(['auth', 'verified']);
    Route::get('surat-keluar-edaran', [\App\Http\Controllers\Program\Surat\SuratKeluarController::class, 'ViewEdaran'])->name('surat.keluar.edaran')->middleware(['auth', 'verified']);
    Route::post('surat-keluar-cetak', [\App\Http\Controllers\Program\Surat\SuratKeluarController::class, 'SuratKeluarCetak'])->name('surat.keluar.cetak')->middleware(['auth', 'verified']);
    Route::resource('surat-keterangan', \App\Http\Controllers\Program\Surat\Suket\SuratSuketController::class)->middleware(['auth', 'verified']);
    // Surat Pernyataan
    // Surat Tugas
    Route::resource('surat-undangan', \App\Http\Controllers\Program\Surat\Undangan\SuratUndanganController::class)->middleware(['auth', 'verified']);
    Route::resource('surat-edaran', \App\Http\Controllers\Program\Surat\Edaran\SuratEdaranController::class)->middleware(['auth', 'verified']);

    Route::resource('surat-mou', \App\Http\Controllers\Program\Surat\MOU\SuratMOUController::class)->middleware(['auth', 'verified']);
    Route::resource('surat-permohonan', \App\Http\Controllers\Program\Surat\Permohonan\SuratPermohonanController::class)->middleware(['auth', 'verified']);
    Route::resource('surat-program-kerja', \App\Http\Controllers\Program\Surat\ProgramKerja\SuratProgramKerjaController::class)->middleware(['auth', 'verified']);
    Route::resource('adart', \App\Http\Controllers\Surat\Adart\AdartController::class)->middleware(['auth', 'verified']);
});
