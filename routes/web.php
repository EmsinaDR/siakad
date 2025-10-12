<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['phpmyadmin', 'auth'])->get('phpmyadmin/{any?}', function () {
    return redirect('phpmyadmin/index.php'); // redirect ke folder phpMyAdmin
})->where('any', '.*');

require __DIR__ . '/auth.php';
Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->middleware('CekDataSekolah')->name('login'); // Pastikan hanya middleware ini yang diterapkan untuk login

// Proses Absen sebaiknya tanpa auth
Route::GET('absensi/absen-siswa-ajax', [App\Http\Controllers\Absensi\EabsenController::class, 'IndexAjax'])->name('absensi.siswa.index.ajax');
// Route::GET('absen-guru-ajax', [EabsenGuruController::class, 'IndexGuruAjax'])->name('guru.index.ajax');
Route::GET('absensi/absen-guru-ajax', [\App\Http\Controllers\Absensi\EabsenGuruController::class, 'IndexGuruAjax'])->name('absensi.guru.index.ajax');

// Whatsapp
Route::resource('whatsapp/penjadwalan', \App\Http\Controllers\Whatsapp\PenjadwalanPesanController::class); // Penjadwalan internal
Route::get('template/{id}', [\App\Http\Controllers\Program\Template\TemplateDokumenController::class, 'getEdaranTemplates'])->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::get('no-surat-get', [\App\Http\Controllers\Program\Surat\SuratKlasifikasiController::class, 'NoSuratGen'])->name('no.surat.get')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);


// Ajax
Route::GET('api-emateri-mapel-to-materi/{mapel_id}/{materi}', [App\Http\Controllers\Learning\EmateriController::class, 'ematerimateritosub'])->name('ematerimateritosub')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::GET('api-emateri-sub-to-indikator/{materi}/{sub_materi}', [App\Http\Controllers\Learning\EmateriController::class, 'ematerisubtoindikator'])->name('EmateriSubtoIndikator')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::get('get-siswa/{id}', [\App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'getSiswa'])->name('get.siswa');
Route::get('get-pembayaran-komite/{tingkat_id}', [App\Http\Controllers\Bendahara\KeuanganRiwayatListController::class, 'getPembayaranTingkat'])->name('get.pembayarantingkat')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::get('get-siswa-by-tingkat/{tingkat_id}', [\App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class, 'getSiswaByTingkat'])->name('get.siswa.by.tingkat')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
