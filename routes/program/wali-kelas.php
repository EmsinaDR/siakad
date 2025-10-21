<?php

use Illuminate\Support\Facades\Route;

// Route::prefix('wali-kelas')->group(function () {
//     // Tambahkan route modul di sini
// });
Route::prefix('/wali-kelas/{kelas_id}')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::GET('data-siswa', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_DataSiswa'])->name('Walkes-DataSiswa.index');
        Route::PUT('data-siswa', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'Walkes_DataSiswa'])->name('Walkes-DataSiswa.update');
        Route::GET('data-jurnal-kelas', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'Walkes_Datajurnal'])->name('Walkes-DataJurnal.index');
        Route::GET('data-nilai', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'Walkes_Datanilai'])->name('Walkes-DataNilai.index');
        //Nilai Tugas
        Route::POST('data-nilai-tugas-siswa', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_Datanilai_tugas'])->name('Walkes-DataNilai.tugas');
        Route::GET('data-nilai-tugas-siswa', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_Datanilai_tugas'])->name('Walkes-DataNilai.tugas');
        //Nilai Ulangan
        Route::POST('data-nilai-ulangan-siswa', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_Datanilai_ulangan'])->name('Walkes-DataNilai.ulangan');
        Route::GET('data-nilai-ulangan-siswa', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_Datanilai_ulangan'])->name('Walkes-DataNilai.ulangan');
        //Nilai PTS dan PAS
        Route::POST('data-nilai-pts-pas-siswa', [App\Http\Controllers\Learning\EnilaiPtsPasController::class, 'Walkes_Datanilai_pts_pas'])->name('Walkes-DataNilai.pts_pas');
        Route::GET('data-nilai-pts-pas-siswa', [App\Http\Controllers\Learning\EnilaiPtsPasController::class, 'Walkes_Datanilai_pts_pas'])->name('Walkes-DataNilai.pts_pas');
        Route::GET('data-inventaris', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'Walkes_Datainventaris'])->name('Walkes-Datainventaris.index');
        Route::GET('data-bk', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_DataBK'])->name('Walkes-DataBK.index');
        Route::GET('data-absensi', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_DataAbsensi'])->name('Walkes-DataAbsensi.index');
        Route::GET('data-rakap-absensi', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_DataRekapAbsensi'])->name('Walkes-DataRekapAbsensi.index');
        Route::GET('data-kredit-point', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_DataBKKreditPoint'])->name('Walkes-DataBKKreditPoint.index');
        Route::GET('data-petugas-upacara', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_DataPetugasUpacara'])->name('Walkes-DataPetugasUpacara.index');
        Route::GET('data-petugas-piket', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_DataPetugaspiket'])->name('Walkes-DataPetugaspiket.index');
        // Route::resource('data-struktur-kelas', DetailsiswaController::class);
        Route::GET('data-struktur-kelas', [App\Http\Controllers\Walkes\WaliKelasController::class, 'Walkes_DataStrukturKelas'])->name('Walkes-DataStrukturKelas.index');
        // Route::resource('data-siswa', DetailsiswaController::class);
        Route::resource('data-bk', App\Http\Controllers\Walkes\WaliKelasController::class);
        Route::resource('data-nilai', App\Http\Controllers\Walkes\WaliKelasController::class);
        Route::resource('data-petugas-upacara', App\Http\Controllers\Walkes\WaliKelasController::class);
        Route::resource('data-jadwal-piket', App\Http\Controllers\Walkes\WaliKelasController::class);
        Route::GET(
            '/data-jadwal-piket/print',
            [App\Http\Controllers\Walkes\JadwalPiketController::class, 'printDataJadwalPiket']
        )->name('print.data_jadwal_piket');
    }
);