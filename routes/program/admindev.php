<?php

use App\Http\Controllers\AdminDev\ModulController;
use App\Models\AdminDev\Modul;
use Illuminate\Support\Facades\Route;


// php artisan make:custom-controller AdminDev/ModulController modul/is_aktiv  modul-controll

// Khusus untuk admindev, gunakan middleware is_admindev tanpa token
Route::middleware(['web', 'auth', 'CekDataSekolah', 'verified', 'is_admindev'])->prefix('admindev')->group(function () {
    // Route::resource('tokenapp', TokenController::class);
    Route::get('tokenapp', [\App\Http\Controllers\AdminDev\TokenController::class, 'index'])->name('tokenapp.index')->middleware(['auth', 'CekDataSekolah', 'verified']);
    Route::post('tokenapp', [\App\Http\Controllers\AdminDev\TokenController::class, 'update'])->name('tokenapp.update')->middleware(['auth', 'CekDataSekolah', 'verified']);
    Route::resource('control-program', \App\Http\Controllers\AdminDev\ControlMenuController::class)->middleware(['auth', 'verified']);
    Route::post('control-program/{control_program}', [\App\Http\Controllers\AdminDev\ControlMenuController::class, 'update'])->middleware(['auth', 'CekDataSekolah', 'verified'])->name('admindev.update.control');
    Route::PATCH('control-program-user/{id}', [\App\Http\Controllers\AdminDev\ControlMenuController::class, 'updateUser'])->middleware(['auth', 'CekDataSekolah', 'verified'])->name('admindev.user');
    Route::resource('progres-aplikasi', \App\Http\Controllers\AdminDev\ProgresAplikasiController::class)->middleware(['auth', 'verified']);
    Route::get('copy-fitur/{progres_aplikasi}', [\App\Http\Controllers\AdminDev\ProgresAplikasiController::class, 'CopyData'])->name('copy-fitur');
    Route::resource('svg-to-png', \App\Http\Controllers\AdminDev\SvgPngController::class)->middleware(['auth', 'verified']);
    Route::post('all-in-kartu', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'AllInKartu'])->name('all.in.kartu');
    Route::post('all-in-kartu-kelas', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'AllInKartuKelas'])->name('all.in.kartu.kelas');
    Route::post('generate-karpel', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateKarpel'])->name('generate.karpel');
    Route::post('generate-kartu-guru', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateKartuGuru'])->name('generate.kartu.guru');
    Route::get('generate-nisn', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateNisn'])->name('generate.nisn');
    Route::get('generate-nisn-array', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateNisnArray'])->name('generate.nisn.array');
    Route::get('generate-kartu-pembayaran', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateKartuPembayaran'])->name('generate.kartu.pembayaran.array');
    Route::get('generate-cocard', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateCoCard'])->name('generate.cocard');
    Route::get('generate-sertifikat', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateSertifikat'])->name('generate.sertifikat');

    Route::resource('control-program', \App\Http\Controllers\AdminDev\ControlMenuController::class)->middleware(['auth', 'verified']);
    Route::resource('data-kerjasama', \App\Http\Controllers\Paket\Kerjasama\DataKerjasamaController::class)->middleware(['auth', 'verified']);
    Route::resource('harga-paket', \App\Http\Controllers\Paket\Kerjasama\HargaPaketController::class)->middleware(['auth', 'verified']);
    Route::post('modul-ubah-masal', [ModulController::class, 'ModulUbahMasal'])->name('modul.ubah.masal');
    Route::resource('sosialisasi-vendor', \App\Http\Controllers\AdminDev\SosialisasiAdminDevController::class)->middleware(['auth', 'verified']); //Belum
    Route::resource('data-vendor', \App\Http\Controllers\AdminDev\DataVendorController::class)->middleware(['auth', 'verified']); //Belum
    Route::resource('modul-app', \App\Http\Controllers\AdminDev\ModulController::class)->middleware(['auth', 'CekDataSekolah', 'verified']); //Belum
    Route::get('data-kartu', [\App\Http\Controllers\AdminDev\DataVendorController::class, 'DataKarpel'])->name('data.kartu')->middleware(['auth', 'CekDataSekolah', 'verified']);
    Route::resource('helper-auto-reply-whatsapp', \App\Http\Controllers\AdminDev\HelperSekolahController::class)->middleware(['auth', 'verified']); //Belum
});
