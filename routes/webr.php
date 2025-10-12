<?php

use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';
Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->middleware('CekDataSekolah')->name('login'); // Pastikan hanya middleware ini yang diterapkan untuk login

// Proses Absen sebaiknya tanpa auth
Route::GET('absensi/absen-siswa-ajax', [App\Http\Controllers\Absensi\EabsenController::class, 'IndexAjax'])->name('absensi.siswa.index.ajax');
// Route::GET('absen-guru-ajax', [EabsenGuruController::class, 'IndexGuruAjax'])->name('guru.index.ajax');
Route::GET('absensi/absen-guru-ajax', [\App\Http\Controllers\Absensi\EabsenGuruController::class, 'IndexGuruAjax'])->name('absensi.guru.index.ajax');