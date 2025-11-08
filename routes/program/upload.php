<?php

use Illuminate\Support\Facades\Route;

Route::prefix('program/upload')->group(function () {
    // Tambahkan route modul di sini
    //Gambar
    Route::POST('/logo', [\App\Http\Controllers\UploadFileController::class, 'UploadLogo'])->name('UploadLogo');
    Route::POST('/profile', [\App\Http\Controllers\UploadFileController::class, 'UploadLogo'])->name('UploadLogo');
    Route::POST('/detail-siswa', [\App\Http\Controllers\UploadFileController::class, 'detailsiswa'])->name('detailsiswa');
    Route::POST('/detail-siswa-kelas', [\App\Http\Controllers\ExcelController::class, 'SiswaInKelas'])->name('SiswaInKelas');
    Route::POST('/detail-guru', [\App\Http\Controllers\UploadFileController::class, 'detailguru'])->name('detailguru');

    Route::POST('/materi', [\App\Http\Controllers\UploadFileController::class, 'UploadLogo'])->name('UploadLogo');
    Route::POST('/kreditpoint', [\App\Http\Controllers\UploadFileController::class, 'UploadLogo'])->name('UploadLogo');
    Route::POST('/foto-guru/{id}', [\App\Http\Controllers\UploadFileController::class, 'UploadFotoGuru'])->name('UploadFotoGuru');
    //Excel
    Route::post('/upload-excel', [\App\Http\Controllers\ExcelController::class, 'uploadExcel'])->name('upload.excel'); // Upload Siswa
    Route::POST('/testpage/uploader', [\App\Http\Controllers\TestpageController::class, 'Uploader'])->name('testpage.excel');
    Route::GET('/upload-excel', [\App\Http\Controllers\ExcelController::class, 'showForm'])->name('upload.excel.form');
    // Upload Target Siswa PPDB
    Route::POST('upload-target-peserta-sosialisasi', [\App\Http\Controllers\ExcelController::class, 'UploadTargetSosialisasi'])->name('upload.target.sosialisasi');
});
