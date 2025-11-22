<?php

use Carbon\Carbon;
use App\Models\Absensi\Eabsen;
use App\Models\Absensi\EabsenGuru;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Absensi\EabsenController;
use App\Http\Controllers\Absensi\EabsenGuruController;
// Absensi Guru
// Route::resource('absensi/absen-guru', \App\Http\Controllers\Absensi\EabsenGuruController::class)->middleware(['auth', 'verified'])->middleware(['web']);
Route::middleware(['web',])->name('absensi.')->prefix('absensi')->group(function () {

    Route::POST('store-guru-ajax-fx', [EabsenGuruController::class, 'storeGuruAjax'])->name('store.guru.ajax');
    Route::POST('store-siswa-ajax', [EabsenController::class, 'storeSiswaAjax'])->name('store.siswa.ajax');

    Route::get('/rekap-absensi-per-kelas', [EabsenController::class, 'rekapPerKelasAjax'])
        ->name('rekap.absen.ajax');

    // Route::get('/list-guru', function () {
    //     $absensi = \App\Models\Absensi\EabsenGuru::with('guru')
    //         ->whereDate('created_at', Carbon::today()) // ✅ Filter hari ini saja
    //         ->orderByDesc('created_at')
    //         ->get()
    //         ->map(function ($item) {
    //             $jamMasuk = Carbon::parse($item->created_at->format('Y-m-d') . ' 07:00:00');
    //             $waktuAbsen = $item->created_at;
    //             $terlambat = $waktuAbsen->greaterThan($jamMasuk)
    //                 ? $waktuAbsen->diff($jamMasuk)->format('%H:%I:%S')
    //                 : null;

    //             return [
    //                 'gelar'  => $item->guru->gelar ?? '-',
    //                 'nama_guru'  => $nama_guru ?? '-',
    //                 'kode_guru'  => $item->guru->kode_guru ?? '-',
    //                 'waktu'      => $waktuAbsen->format('Y-m-d H:i:s'),
    //                 'terlambat'  => $terlambat ?? 'Tepat Waktu',
    //             ];
    //         });

    //     return response()->json($absensi);
    // })->name('list.guru');
});

/*



php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
cls
composer dump-autoload

*/
Route::middleware(['web', 'auth'])->name('absensi.')->prefix('absensi')->group(function () {
    // dd('oke');
    // Absensi Siswa
    Route::resource('data-absensi-siswa', App\Http\Controllers\Absensi\EabsenController::class);
    Route::POST('absen-siswa-manual', [App\Http\Controllers\Absensi\EabsenController::class, 'absenManual'])->name('AbsenManual');
    Route::GET('absen-siswa', [App\Http\Controllers\Absensi\EabsenController::class, 'absensiSiswa'])->name('absensiSiswa');
    Route::GET('rekap-absensi-cetak', [App\Http\Controllers\Absensi\EabsenController::class, 'RekapAbsensicetak'])->name('rekap.absensi.cetak');
    Route::POST('riwayat-absensi-siswa', [App\Http\Controllers\Absensi\EabsenController::class, 'RiwayatAbsenGlobalSiswa'])->name('riwayat.absensi.global');
    // Absensi Guru
    Route::POST('data-absensi-guru', [App\Http\Controllers\Absensi\EabsenController::class, 'storeAbsensiGuru'])->name('absen.guru.store');
    // Route::GET('absen-guru', [App\Http\Controllers\Absensi\EabsenController::class, 'absensiGuru'])->name('scan.guru');
    Route::resource('ijin-digital-siswa', \App\Http\Controllers\Absensi\DataIjinDigitalController::class);
    //Versi ajax
    // Proses Absen sebaiknya tanpa auth
    Route::GET('absen-siswa-ajax', [App\Http\Controllers\Absensi\EabsenController::class, 'IndexAjax'])->name('absensi.index.ajax');

    // Absensi Guru
    Route::resource('absen-guru', \App\Http\Controllers\Absensi\EabsenGuruController::class)->middleware(['auth', 'verified']);
    Route::GET('absen-guru-ajax', [App\Http\Controllers\Absensi\EabsenGuruController::class, 'IndexGuruAjax'])->name('absensi.guru.index.ajax');
    // Route::POST('store-guru-ajax-in', [App\Http\Controllers\Absensi\EabsenGuruController::class, 'storeGuruAjax'])->name('absensi.storex.guru.ajax');
    Route::resource('pulang-cepat', \App\Http\Controllers\Absensi\PulangCepatController::class)->middleware(['auth', 'verified']); //
    // via Dompdf
    // Route::get('export-absensi-guru', [\App\Http\Controllers\Absensi\EabsenGuruController::class, 'ExportAbsensiGuru'])->name('export.absensi.guru');
});
