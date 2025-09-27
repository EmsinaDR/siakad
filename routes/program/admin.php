<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin/seting')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(function () {

    Route::resource('siswa', App\Http\Controllers\User\Siswa\DetailsiswaController::class);
    Route::get('siswa-cetak/{id}', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'SiswaCetak'])->name('siswa.cetak');

    Route::resource('guru', App\Http\Controllers\User\Guru\DetailguruController::class);
    Route::resource('karyawan', App\Http\Controllers\User\Karyawan\KaryawanController::class);
    Route::resource('alumni', App\Http\Controllers\User\Alumni\DetailAlumniController::class);
    Route::resource('etapel', App\Http\Controllers\Admin\EtapelController::class);
    Route::resource('kelas', App\Http\Controllers\Admin\EkelasController::class);
    Route::post('pindah-kelas', [\App\Http\Controllers\Admin\EkelasController::class, 'PindahKelas'])->name('ekelas.pindah');
    Route::resource('emapel', App\Http\Controllers\Admin\EmapelController::class);
    Route::resource('emengajar', App\Http\Controllers\Learning\EmengajarController::class);
    Route::resource('laboratorium', App\Http\Controllers\Laboratorium\ElaboratoriumController::class);

    Route::post('/emapel/mapelaktivkan', [\App\Http\Controllers\Admin\EmapelController::class, 'mapelaktivkan'])->name('Emapel.mapelaktivkan');
    Route::post('/emapel/tambahmapel', [\App\Http\Controllers\Admin\EmapelController::class, 'TambahMapel'])->name('emapel.TambahMapel');

    Route::resource('role-guru', App\Http\Controllers\Admin\RoleController::class);
    Route::get('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_index'])->name('role-siswa.index');
    Route::post('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_store'])->name('role-siswa.store');
    Route::patch('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_update'])->name('role-siswa.update');
    Route::delete('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_destroy'])->name('role-siswa.destroy');
    Route::put('role-siswa-reseter', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_reseter'])->name('role-siswa.reseter');
    Route::put('role-siswa', [App\Http\Controllers\Admin\RoleController::class, 'role_siswa_lock'])->name('role-siswa.lock');

    Route::resource('peraturan', App\Http\Controllers\Admin\PeraturanController::class);

    // Identitas: Perlu tambahan CheckAdmin
    Route::resource('identitas', App\Http\Controllers\Admin\IdentitasController::class)->middleware(['CheckAdmin']);

    // Seting Pengguna
    Route::resource('seting-pengguna-program', \App\Http\Controllers\Program\SetingPenggunaController::class);
    Route::resource('seting-pengguna-program-katu', \App\Http\Controllers\Program\SetingPenggunaKaTUController::class);

    // Kartu QR: Beberapa hanya butuh auth & verified
    Route::resource('kartu-qr', \App\Http\Controllers\Admin\Cetak\CetakQrAbsensiController::class)->middleware(['auth', 'verified']);
    Route::get('kartu-qr-cetak-siswa', [\App\Http\Controllers\Admin\Cetak\CetakQrAbsensiController::class, 'Cetaksiswa'])->name('cetak.kartu.absensi.siswa');
    Route::get('kartu-qr-cetak-guru', [\App\Http\Controllers\Admin\Cetak\CetakQrAbsensiController::class, 'CetakGuru'])->name('cetak-kartu.absensi.guru');

    // Ajax
    Route::post('emengajar/UpdateMengajar', [App\Http\Controllers\Learning\EmengajarController::class, 'UpdateMengajar'])->name('UpdateMengajar');

    Route::resource('reset-password', \App\Http\Controllers\Admin\ResetPasswordController::class)
        ->middleware(['auth', 'verified']);

    Route::post('ubah-data-karpel', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'ubahDataKarpel'])->name('ubah.data.karpel');
});
Route::get('siswa-cetak/{id}', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'cekData'])->name('siswa.cetak');
Route::POST('siswa-cetak/{id}', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'SiswaCetak'])->name('siswa.cetak');
Route::get('/get-siswa/{id}', [\App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'getSiswa'])->name('get.siswa');

Route::POST('/siswa/scan', [\App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'getByNis'])->name('siswa.scan');

Route::POST('guru/create', [App\Http\Controllers\Admin\UserController::class, 'createuser'])->name('CreateUserGuru')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::GET('ekelasx', [\App\Http\Controllers\Admin\EkelasController::class, 'updatex'])->name('UserKaryawanx')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);

//kelas
Route::POST('/kelas/createbulk', [\App\Http\Controllers\Admin\EkelasController::class, 'createbulk'])->name('CreateBulkKelas')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::POST('/kelas/updatewalkes', [\App\Http\Controllers\Admin\EkelasController::class, 'updatewalkes'])->name('UpdateWalkes')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
