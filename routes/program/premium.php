<?php

use Mpdf\Mpdf;
use App\Models\User;
use App\Models\Ekaldik;
use Carbon\Carbon;
use App\Mail\KirimEmail;
use App\Models\Admin\Ekelas;
use App\Models\Admin\Emapel;
use App\Models\Admin\Etapel;
use App\Models\Dokumenttest;
use Illuminate\Http\Request;
use App\Models\Admin\Identitas;
use App\Models\Learning\Emengajar;
use App\Models\User\Guru\Detailguru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Program\PKKS\DataPKKS;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;
use App\Models\User\Siswa\Detailsiswa;
use App\Http\Controllers\ExcelController;
use App\Models\Bendahara\BendaharaKomite;
use App\Http\Controllers\bk\EbkController;
use App\Http\Controllers\EkaldikController;
use App\Models\Program\Tupoksi\DataTupoksi;
use App\Http\Controllers\TestpageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UploadFileController;
use App\Models\Program\Surat\SuratKlasifikasi;
use App\Models\User\Alumni\PengajuanLegalisir;
use App\Http\Controllers\Admin\EkelasController;
use App\Http\Controllers\Admin\EmapelController;
use App\Http\Controllers\Admin\EtapelController;
use App\Models\Laboratorium\RiwayatLaboratorium;
use App\Models\Program\Template\TemplateDokumen;
use App\Models\Aplikasi\Tetntang\TentangAplikasi;
use App\Models\Tools\Template\TemplateSertifikat;
use App\Http\Controllers\AdminDev\TokenController;
use App\Http\Controllers\Admin\IdentitasController;
use App\Http\Controllers\Admin\PeraturanController;
use App\Models\Program\Dokumentasi\DataDokumentasi;
use App\Models\Program\Supervisi\SupervisiInstrument;
use App\Http\Controllers\Learning\EmengajarController;
use Database\Seeders\Program\Tagline\DataTaglineSeeder;
use App\Http\Controllers\User\Guru\DetailguruController;
use App\Http\Controllers\Program\SetingPenggunaController;
use App\Http\Controllers\User\Karyawan\KaryawanController;
use App\Http\Controllers\User\Siswa\DetailsiswaController;
use App\Http\Controllers\Program\Rapat\DataRapatController;
use App\Http\Controllers\User\Alumni\DetailAlumniController;
use App\Http\Controllers\Admin\Cetak\CetakQrAbsensiController;
use App\Http\Controllers\Laboratorium\ElaboratoriumController;
use App\Http\Controllers\Program\SetingPenggunaKaTUController;
use App\Http\Controllers\Program\Tagline\DataTaglineController;
use App\Http\Controllers\Registrasi\RegistrasiSekolahController;
use App\Http\Controllers\Bendahara\RencanaAnggaranListController;
use App\Http\Controllers\Program\Proker\DataProgramKerjaController;
use App\Http\Controllers\Program\Template\TemplateDokumenController;
use App\Http\Controllers\Aplikasi\Tetntang\TentangAplikasiController;
use App\Http\Controllers\Tools\Template\TemplateSertifikatController;
use App\Http\Controllers\Program\Dokumentasi\DataDokumentasiController;
use App\Models\Program\CBT\BankSoal;

Route::get('/pdf-ke-gambar', function () {
    $magickPath = '"C:\Program Files\ImageMagick-7.1.2-Q16-HDRI\magick.exe"';
    $pdfPath = base_path('Whatsapp/Uploads/Surat-Aktif-2025001.pdf');
    $outputPath = base_path('Whatsapp/Uploads/Surat-Aktif-2025001.jpg');

    $command = "$magickPath -density 150 \"$pdfPath\"[0] -quality 100 \"$outputPath\"";

    exec($command, $output, $returnVar);

    if ($returnVar !== 0) {
        dd("Gagal convert: ", $output);
    } else {
        dd("Sukses convert ke JPG!");
    }
});
// Route::resource('portal-siswa', \App\Http\Controllers\Program\Portal\PortalSiswaController::class)->middleware(['auth', 'verified']); //Data Siswa meminta jemputan / cek data nilai / cek data pembayaran / dll
// Route::resource('/', \App\Http\Controllers\Program\FrontController::class); // Bagian Front End

Route::resource('registrasi-sekolah', RegistrasiSekolahController::class);
Route::get('siswa-cetak/{id}', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'SiswaCetak'])->name('siswa.cetak');
Route::GET('/', function () {
    $breadcrumb = 'Home / Dasboard User';

    // info Dashboard
    $etapel = App\Models\Admin\Etapel::select('id')->where('aktiv', 'Y')->first();
    $jumlah_siswa = Cache::tags(['chace_jumlah_siswa'])->remember('remember_jumlah_siswa', now()->addHours(2), function () {
        return \Illuminate\Foundation\Auth\User::where('posisi', 'Siswa')->count();
    });

    HapusCacheDenganTag('jumlah_alumni');
    HapusCacheDenganTag('jumlah_alumni');
    $jumlah_alumni = Cache::tags(['Cache_jumlah_alumni'])->remember('Remember_jumlah_alumni', now()->addMinutes(10), function () {
        return \App\Models\User\Siswa\Detailsiswa::where('status_siswa', 'lulus')->get()->count();
        // return 5;
    });

    HapusCacheDenganTag('TAG_USER_SISWA');
    $jumlah_guru = Cache::tags(['jumlah_guruchace'])->remember('jumlah_gururemember', now()->addHours(2), function () {
        return \Illuminate\Foundation\Auth\User::where('posisi', 'Guru')->count();
    });

    HapusCacheDenganTag('TAG_USER_SISWA');
    $jumlah_karyawan = Cache::tags(['jumlah_karyawanchace'])->remember('jumlah_karyawanremember', now()->addHours(2), function () {
        return User::where('posisi', 'Karyawan')->count();;
    });

    HapusCacheDenganTag('TAG_USER_SISWA');

    $etapel = Etapel::select('id')->where('aktiv', 'Y')->first();
    $emapels = Cache::tags(['emapelschace'])->remember('emapelsremember', now()->addHours(2), function () use ($etapel) {
        return Emengajar::where('tapel_id', $etapel->id)->select('mapel_id')->distinct('mapel_id')->count();;
    });

    $jumlah_kelas = Cache::tags(['jumlahKelaschace'])->remember('jumlahKelasremember', now()->addHours(2), function () use ($etapel) {
        return Ekelas::where('tapel_id', $etapel->id)->get()->count();
    });

    $jumlah_laboratorium = Cache::tags(['jumlahlabschace'])->remember('jumlahlabsremember', now()->addHours(2), function () use ($etapel) {
        return App\Models\Laboratorium\RiwayatLaboratorium::where('tapel_id', $etapel->id)->where('aktiv', 'Y')->get()->count();
    });
    $info =  $jumlah_siswa . '/' . $jumlah_guru . '/' . $jumlah_karyawan . '/' . $emapels  . '/' . $jumlah_kelas  . '/' . $jumlah_laboratorium  . '/' . $jumlah_alumni;
    $title = 'Dasboard';
    $identitas = Identitas::first();
    $dataUserDasboard = Cache::tags(['chace_dataUserDasboard'])->remember('remember_dataUserDasboard', now()->addHours(2), function () {
        return User::where('posisi', 'Siswa')->get();
    });
    //Untuk Hapusnya :
    return view('dasboard', compact(
        'title',
        'breadcrumb',
        'dataUserDasboard',
        'info',
        'identitas',
    ));
})->middleware(['auth', 'CekDataSekolah', 'token.check', 'CheckAktivated'])->name('Dashborad');
Route::middleware(['auth', 'Is_guru'])->get('/dashboard', function () {
    return view('dasboard');
});
Route::GET('/notaktiv', function () {
    return 'notaktiv';
})->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->name('notaktiv');

// fornend
Route::resource('tagline', DataTaglineController::class);
// Admin
Route::prefix('/admin/seting')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(function () {

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
});
Route::get('siswa-cetak/{id}', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'cekData'])->name('siswa.cetak');
Route::POST('siswa-cetak/{id}', [App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'SiswaCetak'])->name('siswa.cetak');

//Wali Kelas
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
Route::GET('cetak', [App\Http\Controllers\Walkes\WaliKelasController::class, 'printDataJadwalPiket'])->name('print.data_jadwal_piket')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);


Route::POST('/guru/create', [App\Http\Controllers\Admin\UserController::class, 'createuser'])->name('CreateUserGuru')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::GET('/ekelasx', [\App\Http\Controllers\Admin\EkelasController::class, 'updatex'])->name('UserKaryawanx')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);

//kelas
Route::POST('/kelas/createbulk', [\App\Http\Controllers\Admin\EkelasController::class, 'createbulk'])->name('CreateBulkKelas')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::POST('/kelas/updatewalkes', [\App\Http\Controllers\Admin\EkelasController::class, 'updatewalkes'])->name('UpdateWalkes')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);

// Elearning // midleware guru Is_guru
Route::prefix('/elearning/{mapel_id}/{semester}/{tingkat_id}/{kelas_id}')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
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
//Emateri
//Ajax pengambilan \App\Models\User\Siswa\Detailsiswa model API
//---------------------------------------------------------------------------------------------------------------------------

Route::GET('/api-emateri-mapel-to-materi/{mapel_id}/{materi}', [App\Http\Controllers\Learning\EmateriController::class, 'ematerimateritosub'])->name('ematerimateritosub')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::GET('/api-emateri-sub-to-indikator/{materi}/{sub_materi}', [App\Http\Controllers\Learning\EmateriController::class, 'ematerisubtoindikator'])->name('EmateriSubtoIndikator')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
//Ajax
Route::get('/get-siswa/{id}', [\App\Http\Controllers\User\Siswa\DetailsiswaController::class, 'getSiswa'])->name('get.siswa');
Route::get('/get-pembayaran-komite/{tingkat_id}', [App\Http\Controllers\Bendahara\KeuanganRiwayatListController::class, 'getPembayaranTingkat'])->name('get.pembayarantingkat')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::get('/get-siswa-by-tingkat/{tingkat_id}', [\App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class, 'getSiswaByTingkat'])->name('get.siswa.by.tingkat')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
//---------------------------------------------------------------------------------------------------------------------------

//Pembina
//Pembina Ekstra
Route::prefix('/ekstrakurikuler')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(function () {
    // Resource routes
    Route::resource('/peserta-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\PesertaEkstraController::class);
    Route::resource('/absensi-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\DaftarHadirEkstraController::class);
    Route::resource('/pengaturan-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\PengaturanEkstraController::class);
    Route::resource('/materi-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\MateriEkstraController::class);
    Route::resource('/jurnal-ekstra', App\Http\Controllers\WakaKesiswaan\Ekstra\JurnalEkstraController::class);

    // Routes untuk AJAX data
    Route::get('/get-materi', [App\Http\Controllers\WakaKesiswaan\Ekstra\MateriEkstraController::class, 'getMateri']);
    Route::get('/get-sub-materi/{materi}', [App\Http\Controllers\WakaKesiswaan\Ekstra\MateriEkstraController::class, 'getSubMateri']);
    Route::get('/get-indikator-materi/{subMateri}', [App\Http\Controllers\WakaKesiswaan\Ekstra\MateriEkstraController::class, 'getIndikatorMateri']);
});
Route::prefix('ppdb')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('peserta-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\PPDBPesertaController::class);
        Route::resource('riwayat-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\RiwayatPendaftaranPPDBController::class);
        Route::resource('pengumuman-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\PengumumanPPDBController::class);
        Route::post('pengumuman-ppdb-bulk', [App\Http\Controllers\WakaKesiswaan\PPDB\PengumumanPPDBController::class, 'PengumumanPPDBBulk'])->name('pengumuman.ppdb.bulk');
        Route::resource('pembayaran-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\PembayaranPPDBController::class);
        Route::resource('pengaturan-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\PengaturanPPDBController::class);
        Route::resource('jadwal', App\Http\Controllers\WakaKesiswaan\PPDB\PPDBPesertaController::class);
        Route::get('formulir-ppdb', [App\Http\Controllers\WakaKesiswaan\PPDB\PPDBPesertaController::class, 'FormulirPPDB'])->name('formulir.ppdb');
        Route::resource('piket-ppdb', \App\Http\Controllers\WakaKesiswaan\PPDB\PiketPPDBController::class);
        // Target Peserta Sosialisasi PPDB
        Route::resource('target-peserta-sosialisasi', App\Http\Controllers\WakaKesiswaan\PPDB\DataSiswaTargetController::class)->middleware(['auth', 'verified']);
        // php artisan make:custom-controller FolderData/TargetPesertaController fillable
    }
);
Route::get('ppdb/formulir-ppdb-new', [App\Http\Controllers\WakaKesiswaan\PPDB\PPDBPesertaController::class, 'FormulirPPDBnew'])->name('formulir.ppdb.new');
//Pembina Laboratorium
Route::prefix('/laboratorium')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('/dashboard-laboratorium', App\Http\Controllers\Laboratorium\DashboardLaboratoriumController::class);
        Route::resource('/inventaris-laboratorium', App\Http\Controllers\Laboratorium\InventarisLaboratoriumController::class);
        Route::resource('/jadwal-laboratorium', App\Http\Controllers\Laboratorium\JadwalLaboratoriumController::class);
        Route::resource('/peraturan-laboratorium', App\Http\Controllers\Laboratorium\PeraturanLaboratoriumController::class);
        // Route::resource('/jadwal-laboratorium', App\Http\Controllers\Laboratorium\JadwalLaboratoriumController::class);
        Route::resource('/pengaturan-laboratorium', App\Http\Controllers\Laboratorium\PengaturanLaboratoriumController::class);
    }
    // php artisan make:controller Laboratorium/DashboardLaboratoriumController -m Laboratorium/DashboardLaboratorium
    // php artisan make:controller Laboratorium/JadwalLaboratoriumController -m Laboratorium/JadwalLaboratorium
    // php artisan make:controller Laboratorium/InventarisLaboratoriumController -m Laboratorium/InventarisLaboratorium
    // php artisan make:controller Laboratorium/PengaturanLaboratoriumController -m Laboratorium/PengaturanLaboratorium
    // php artisan make:controller Laboratorium/PeraturanLaboratoriumController -m Laboratorium/PeraturanLaboratorium
);
//Perpustakaan
Route::prefix('/perpustakaan')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {

        Route::resource('katalog-buku', App\Http\Controllers\Perpustakaan\EperpuskatalogController::class);
        //Sumber : https://ebook.uimedan.ac.id/home/bidangilmu/bahasa-indonesia
        //https://sikurma.kemenag.go.id/portal/Buku/data_buku?ref_katbook=ZWJnQUlNTDdwZDN6a1pFZjFnTHl0UT09
        //https://smp.itikurih-hibarna.sch.id/katalog-buku-2/
        //https://www.mtsn1balangan.sch.id/p/download-buku-digital-madrasah.html
        //https://smpn4pakem.sch.id/buku-sekolah-elektronik-kelas-78/
        Route::resource('katalog-ebook', App\Http\Controllers\Perpustakaan\EbookController::class);
        Route::resource('peminjaman-buku', App\Http\Controllers\Perpustakaan\EperpuspeminjamController::class);
        Route::resource('pengunjung', App\Http\Controllers\Perpustakaan\EperpuspengunjungController::class);
        Route::resource('pengaturan-perpustakaan', App\Http\Controllers\Perpustakaan\PengaturanPerpustakaanController::class);
        Route::resource('peraturan', App\Http\Controllers\Admin\PeraturanController::class);
        Route::resource('kartu-buku', App\Http\Controllers\Perpustakaan\KartuBukuController::class);
        Route::get('export-kartu-buku', [App\Http\Controllers\Perpustakaan\KartuBukuController::class, 'exportBuKuKartu'])->name('export.kartu.buku');
        Route::get('export-kartu-peminjaman', [App\Http\Controllers\Perpustakaan\KartuBukuController::class, 'exportPdfKartuPeminjaman'])->name('export.kartu.peminjaman.siswa');
        Route::get('kartu-peminjaman', [App\Http\Controllers\Perpustakaan\KartuBukuController::class, 'KartuPeminjaman'])->name('KartuPeminjaman');
        // Route::match(['get', 'post','destroy','update'], '/peraturan', [PengaturanPerpustakaanController::class, 'PeraturanPerpustakaan'])->name('perpustakaan.peraturan');
        Route::get('ajax-peminjam-buku/{siswa_id}', [App\Http\Controllers\Perpustakaan\EperpuspeminjamController::class, 'AjaxPeminjam'])->name('AjaxPeminjam');
    }
);
//BK
Route::prefix('/bimbingan-konseling')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('/bimbingan', App\Http\Controllers\bk\BkbimbinganController::class);
        Route::resource('/bk-data-siswa', App\Http\Controllers\bk\EbkController::class);
        Route::resource('/kredit-point', App\Http\Controllers\bk\EbkkreditpointController::class);
        Route::resource('/pelanggaran', App\Http\Controllers\bk\EbkpelanggaranController::class);
        Route::POST('upload-pelanggaran', [App\Http\Controllers\bk\EbkpelanggaranController::class, 'uploadkreditpoint'])->name('uploadkreditpoint');
        Route::resource('/pengaduan', App\Http\Controllers\bk\EbkpelanggaranController::class);
        Route::GET('bk-surat', [App\Http\Controllers\Dokumen\Surat\SuratController::class, 'surat_bk'])->name('surat_bk'); //controllernya apa
        Route::GET('panggilan', [App\Http\Controllers\Dokumen\Surat\SuratController::class, 's_panggilan'])->name('s_panggilan');
        Route::GET('surat-ijin-km', [App\Http\Controllers\Dokumen\Surat\SuratController::class, 's_ijin'])->name('s_ijin');
        Route::resource('/surat', App\Http\Controllers\Bendahara\BendaharaDaftarUlangController::class);
        // Quesuiner
        Route::resource('dasboard-quesioner', \App\Http\Controllers\Program\Quesioner\DasboardQuesionerController::class);
        Route::resource('pertanyaan-quesioner', \App\Http\Controllers\Program\Quesioner\DataPertanyaanQuesionerController::class);
        Route::resource('jawaban-quesioner', \App\Http\Controllers\Program\Quesioner\JawabnQuesionerController::class)->middleware(['auth', 'verified']);
        // php artisan make:custom-controller Program/Quesioner/JawabnQuesionerController tapel_id/detailsiswa_id/pertanyaan_id,jawaban
        // Route::resource('url', \App\Http\Controllers\Folder\NameController::class)->middleware(['auth', 'verified']);
    }
);
//Program
Route::prefix('/kepala-sekolah')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('/surat-keputusan', \App\Http\Controllers\KepalaSekolah\SuratKeputusanController::class);
        Route::get('surat-keputusan-view/{id}', [\App\Http\Controllers\KepalaSekolah\SuratKeputusanController::class, 'skview'])->name('skview');
        Route::resource('/agenda-kepala', \App\Http\Controllers\KepalaSekolah\SuratKeputusanController::class);
        Route::resource('pembinaan', \App\Http\Controllers\KepalaSekolah\PembinaanController::class)->middleware(['auth', 'verified']);
    }
);
Route::get('/template/{id}', [\App\Http\Controllers\Program\Template\TemplateDokumenController::class, 'getEdaranTemplates'])->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);

Route::get('no-surat-get', [\App\Http\Controllers\Program\Surat\SuratKlasifikasiController::class, 'NoSuratGen'])->name('no.surat.get')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);

Route::prefix('program')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    // studytrace
    // pembuatan angket

    function () {
        //
        Route::resource('kepala-tata-usaha', \App\Http\Controllers\Program\TataUsaha\KepalaTataUsahaController::class)->middleware(['auth', 'verified']);
        // Vote
        Route::prefix('/vote')->group(
            function () {
                Route::resource('pertanyaan-vote', \App\Http\Controllers\Program\Vote\PertanyaanVoteController::class);
                Route::resource('hasil-vote', \App\Http\Controllers\Progtam\Vote\DataJawabanVoteController::class);
                Route::resource('jawaban-vote', \App\Http\Controllers\Program\Vote\DataJawabanVoteController::class);
                // php artisan make:custom-controller Program/Vote/DataJawabanVoteController
                // php artisan make:custom-controller Program/Vote/PertanyaanVoteController
            }
        );
        //E Prestasi
        Route::resource('/prestasi', App\Http\Controllers\Program\Prestasi\DataPrestasiController::class)->middleware(['auth', 'verified']);
        // Surat
        Route::resource('/surat', App\Http\Controllers\Dokumen\Surat\SuratController::class)->middleware(['auth', 'verified']);
        Route::resource('klasifikasi-surat', \App\Http\Controllers\Program\Surat\SuratKlasifikasiController::class)->middleware(['auth', 'verified']);
        Route::resource('surat-masuk', \App\Http\Controllers\Program\Surat\SuratMasukController::class)->middleware(['auth', 'verified']);
        Route::resource('surat-keluar', \App\Http\Controllers\Program\Surat\SuratKeluarController::class)->middleware(['auth', 'verified']);
        Route::post('surat-keluar-save', [\App\Http\Controllers\Program\Surat\SuratKeluarController::class, 'SuratKeluarSvae'])->name('surat.keluar.save')->middleware(['auth', 'verified']);
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
        //Tahfidz
        Route::prefix('/tahfidz')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
            function () {
                Route::resource('peserta-tahfidz', \App\Http\Controllers\Program\Tahfidz\TahfidzPesertaController::class);
                Route::resource('surat-tahfidz', \App\Http\Controllers\Program\Tahfidz\TahfidzPesertaController::class);
                Route::resource('riwayat-hafalan', \App\Http\Controllers\Program\Tahfidz\RiwayatHafalanTahfidzController::class);
                //routeres
            }
        );
        // Dokumens Siswa
        Route::resource('dokumen-siswa', \App\Http\Controllers\Program\Dokumen\DokumenSiswaController::class)->middleware(['auth', 'verified']);
        Route::POST('cetak-dokumen-siswa', [\App\Http\Controllers\Program\Dokumen\DokumenSiswaController::class, 'CetakDokumenSiswa'])->name('cetak.dokumen.siswa');

        Route::prefix('/btq')->group(
            function () {
                Route::resource('peserta-btq', App\Http\Controllers\Program\BTQ\PesertaBTQController::class);
                Route::resource('riwayat-btq', App\Http\Controllers\Program\BTQ\RiwayatBTQController::class);
                //routeres
            }
        );
        Route::prefix('/pembina-osis')->group(
            function () {
                Route::resource('anggota-osis', \App\Http\Controllers\Program\PembinaOsis\AnggotaOsisController::class)->middleware(['auth', 'verified']);
                Route::resource('agenda-osis', \App\Http\Controllers\Program\PembinaOsis\AgendaOsisController::class)->middleware(['auth', 'verified']);
                Route::resource('pendaftaran-osis', \App\Http\Controllers\Program\PembinaOsis\PendaftaranOsisController::class)->middleware(['auth', 'verified']);
                // php artisan make:custom-controller Program/PembinaOsis/AnggotaOsisController
                // php artisan make:custom-controller Program/PembinaOsis/AgendaOsisController
                // php artisan make:custom-controller Program/PembinaOsis/PendaftaranOsisController
            }
        );
        Route::prefix('shalat-jamaah')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
            function () {
                //routeres
                Route::resource('jadwal-shalat', App\Http\Controllers\Program\Shalat\JadwalShalatController::class);
                // Route::get('formulir-tamu', [\App\Http\Controllers\Program\BukuTamu\BukuTamuController::class, 'indexFormulirTamu'])->name('formulir-tamu.index');
                // Zf
            }
        );
        Route::prefix('/buku-tamu')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
            function () {
                //routeres
                Route::resource('data-tamu', \App\Http\Controllers\Program\BukuTamu\BukuTamuController::class);
                Route::get('formulir-tamu', [\App\Http\Controllers\Program\BukuTamu\BukuTamuController::class, 'indexFormulirTamu'])->name('formulir-tamu.index');
                // Zf
            }
        );
        // Legalisir
        Route::resource('legalisir-ijazah', \App\Http\Controllers\User\Alumni\PengajuanLegalisirController::class);

        // Erapat
        Route::prefix('/rapat')->group(
            function () {
                Route::resource('data-rapat', App\Http\Controllers\Program\Rapat\DataRapatController::class);
                Route::resource('berita-acara-rapat', App\Http\Controllers\Program\Rapat\BeritaAcaraRapatController::class);
                Route::resource('daftar-hadir-rapat', App\Http\Controllers\Program\Rapat\DaftarHadirRapatController::class);
                Route::get('data-rapat-cetak/{id}', [\App\Http\Controllers\Program\Rapat\DataRapatController::class, 'CetakDataRapat'])->name('data.rapat.cetak');
            }
        );
        // Dokumentasi
        Route::prefix('/dokumentasi')->group(
            function () {
                Route::resource('data-dokumentasi', App\Http\Controllers\Program\Dokumentasi\DataDokumentasiController::class);
            }
        );
        // SOP
        Route::prefix('/sop')->group(
            function () {
                Route::resource('data-sop', App\Http\Controllers\Program\SOP\DataSOPController::class);
            }
        );
        // Template Dokumen
        Route::get('template-dokumen/search/{key}', [\App\Http\Controllers\Program\Template\TemplateDokumenController::class, 'TemplateKhusus'])->name('TemplateKhusus');
        Route::resource('template-dokumen', \App\Http\Controllers\Program\Template\TemplateDokumenController::class);
        Route::get('template-cetak/{id}', [\App\Http\Controllers\Program\Template\TemplateDokumenController::class, 'TemplateCetak'])->name('template.cetak');
        // SOP
        Route::prefix('/program-kerja')->group(
            function () {
                Route::resource('data-program-kerja', \App\Http\Controllers\Program\Proker\DataProgramKerjaController::class);
            }
        );
        // Supervisi
        Route::prefix('/supervisi')->group(
            function () {
                Route::resource('instrument-supervisi', \App\Http\Controllers\Program\Supervisi\SupervisiInstrumentController::class);
                Route::resource('supervisi-pembelajaran', \App\Http\Controllers\Program\Supervisi\SupervisiPembelajaranController::class);
                Route::get('analisis-supervisi-pembelajaran', [\App\Http\Controllers\Program\Supervisi\SupervisiPembelajaranController::class, 'analisis'])->name('analisis-supervisi-pembelajaran');

                Route::resource('supervisi-perangkat-guru', \App\Http\Controllers\Program\Supervisi\SupervisiPerangkatGuruController::class);
                Route::resource('supervisi-atp-guru', \App\Http\Controllers\Program\Supervisi\SupervisiATPController::class);
                Route::resource('supervisi-modul-ajar-guru', \App\Http\Controllers\Program\Supervisi\SupervisiModulAjarController::class);

                Route::resource('supervisi-laboratorium', \App\Http\Controllers\Program\Supervisi\SupervisiLaboratoriumController::class);
                Route::resource('supervisi-laboran', \App\Http\Controllers\Program\Supervisi\SupervisiLaboranController::class);

                Route::resource('supervisi-wali-kelas', \App\Http\Controllers\Program\Supervisi\SupervisiWaliKelasController::class);
                Route::post('saran-supervisi-wali-kelas', [App\Http\Controllers\Program\Supervisi\SupervisiWaliKelasController::class, 'SaveSaranSupervisiWalkes'])->name('save.saran.supervisi');
                Route::resource('supervisi-perpustakaan', \App\Http\Controllers\Program\Supervisi\SupervisiPerpustakaanController::class);
                // php artisan make:custom-controller Program/Supervisi/Analisis/AnalisisiSupervisiWaliKelasController

                Route::resource('supervisi-waka-kurikulum', \App\Http\Controllers\Program\Supervisi\Waka\SupervisiWakaKurikulumController::class);
                Route::resource('supervisi-waka-kesiswaan', \App\Http\Controllers\Program\Supervisi\Waka\SupervisiWakaKesiswaanController::class);
                Route::resource('supervisi-waka-sarpras', \App\Http\Controllers\Program\Supervisi\Waka\SupervisiWakaSarprasController::class);

                Route::resource('jadwal-supervisi-perangkat', App\Http\Controllers\Program\SOP\DataSOPController::class);
                //Jadwal Supervisi
                //Jadwal Waka
                Route::resource('jadwal-supervisi-waka', \App\Http\Controllers\Program\Supervisi\Jadwal\JadwalSupervisiWakaController::class);
                Route::resource('jadwal-supervisi-guru', \App\Http\Controllers\Program\Supervisi\Jadwal\JadwalSupervisiGuruController::class);

                Route::resource('jadwal-supervisi-laboratorium', \App\Http\Controllers\Program\Supervisi\Jadwal\JadwalSupervisiLaboratoriumController::class);
                Route::resource('jadwal-supervisi-perpustakaan', \App\Http\Controllers\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaanController::class);

                //php artisan make:custom-controller Program/Supervisi/Jadwal/JadwalSupervisiGuruController
                Route::resource('jadwal-supervisi-kbm', App\Http\Controllers\Program\SOP\DataSOPController::class);
                // php artisan make:custom-controller Program/Supervisi/Analisis/AnalisisSupervisiPembelajaranController
                Route::resource('analisis-supervisi-wali-kelas', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiWaliKelasController::class); // Belum Proses
                Route::resource('analisis-supervisi-waka', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisiSupervisiWakaController::class); // Belum Proses
                Route::resource('analisis-supervisi-kbm', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiKbmController::class); // Belum Proses
                Route::resource('analisis-supervisi-modul-ajar', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiModulAjarController::class); // Belum Proses
                Route::resource('analisis-supervisi-laboratorium', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiLaboratoriumController::class); // Belum Proses
                Route::resource('analisis-supervisi-pembelajaran', \App\Http\Controllers\Program\Supervisi\Analisis\AnalisisSupervisiPembelajaranController::class); // Belum Proses
            }
        );
        //https://www.mtsmaarifnugandusari.sch.id/2024/10/pkkm-singkatan-dari-penilaian-kinerja.html

        Route::prefix('/pkks')->group(
            function () {
                Route::resource('data-pkks', \App\Http\Controllers\Program\PKKS\DataPKKSController::class);
                Route::get('data-view-pkks/id_{id}', [\App\Http\Controllers\Program\PKKS\Data\ViewPKKSIDController::class, 'show'])->name('data-view-pkks');
                Route::get('upload', function () {
                    $datas = \App\Models\Program\PKKS\DataPKKS::all(); // Mengambil data untuk dropdown atau list
                    return view('program.pkks.upload', compact('datas'));
                });
                Route::post('upload', [\App\Http\Controllers\Program\PKKS\DataPKKSController::class, 'upload']);
                Route::resource('progres-pkks', \App\Http\Controllers\Program\PKKS\ProgresPKKSController::class);
                Route::resource('/visi-misi', \App\Http\Controllers\Program\VisiMisi\DataVisiMisiController::class);
            }
        );
        Route::resource('pesan-tips', \App\Http\Controllers\Program\Tips\TipsSiswaController::class)->middleware(['auth', 'verified']);
    }
);
Route::get('/program/pkks/data-view-pkks/{id}', [\App\Http\Controllers\Program\StrukturSekolah\DataStrukturSekolahController::class, 'getStrukturData'])->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::patch('/program/pkks/data-view-pkks/{id}', [\App\Http\Controllers\Program\StrukturSekolah\DataStrukturSekolahController::class, 'update'])->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);

// Route untuk memproses upload filekartu
Route::post('/import-doc', [App\Http\Controllers\Program\SOP\DataSOPController::class, 'importDoc'])->name('import.doc')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::prefix('/tools')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(function () {
    Route::resource('template-sertifikat', \App\Http\Controllers\Tools\Template\TemplateSertifikatController::class);
    Route::resource('pengaturan-sertifikat', \App\Http\Controllers\Tools\Template\PengaturanTemplateSertifikatController::class);
    Route::POST('cetak-sertifikat', [\App\Http\Controllers\Tools\Template\PengaturanTemplateSertifikatController::class, 'CetakSertifikat'])->name('cetak.sertifikat');
    // Image Compress
    Route::resource('image', \App\Http\Controllers\ImageController::class);
    Route::POST('image-indexing', [\App\Http\Controllers\ImageController::class, 'indexImage'])->name('tools.compress.img');
    Route::POST('image/compress', [\App\Http\Controllers\ImageController::class, 'compress'])->name('image.compress');
    Route::get('image/download/{id}', [\App\Http\Controllers\ImageController::class, 'download'])->name('image.download');
    Route::post('/image/delete-selected', [\App\Http\Controllers\ImageController::class, 'deleteSelected'])->name('image.delete.selected');
    Route::get('/images/download/all', [\App\Http\Controllers\ImageController::class, 'downloadAll'])->name('image.download.all');
    // CoCard
    Route::resource('cocard', \App\Http\Controllers\Tools\Template\Cocard\CocardController::class)->middleware(['auth', 'verified']);
    Route::POST('cocard-generate', [\App\Http\Controllers\Tools\Template\Cocard\CocardController::class, 'GenerateCocard'])->name('cocard.generate');
    // Foto Digital
    Route::resource('foto-digital-siswa', \App\Http\Controllers\Tools\Foto\FotoSiswaController::class)->middleware(['auth', 'verified']);
    Route::get('foto-digital-guru', [\App\Http\Controllers\Tools\Photo\AmbilFotoController::class, 'FotoDigitalGuru'])->name('foto.digital.guru');
    Route::post('foto-digital-guru-store', [\App\Http\Controllers\Tools\Photo\AmbilFotoController::class, 'storeFotoGuru'])->name('foto.digital.guru.store');
    // Qr Generator
    Route::resource('generator-qrcode', \App\Http\Controllers\Tools\Qr\GeneratorQrController::class)->middleware(['auth', 'verified']);
});

Route::prefix('/karyawan')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('administrasi-cuti', \App\Http\Controllers\Program\Karyawan\AdmBlankoController::class);
    }
);
//Bendahara
Route::middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->prefix('bendahara')->group(
    function () {

        // Bendahara Daftar Ulang
        Route::resource('rencana-anggaran-list', \App\Http\Controllers\Bendahara\RencanaAnggaran\RencanaAnggaranListController::class);
        Route::resource('rencana-anggaran-sekolah', \App\Http\Controllers\Bendahara\RencanaAnggaran\RencanaAnggaranSekolahController::class);
        Route::post('rencana-anggaran-sekolah-ubah-kategori', [\App\Http\Controllers\Bendahara\RencanaAnggaran\RencanaAnggaranSekolahController::class, 'UbahKategori'])->name('kategori.ubah');
        Route::resource('daftar-ulang', App\Http\Controllers\Bendahara\BendaharaDaftarUlangController::class);
        Route::resource('rincian-daftar-ulang', \App\Http\Controllers\Bendahara\BendaharaDaftarUlang\RincianDaftarUlangController::class);
        // php artisan make:custom-controller Bendahara/BendaharaDaftarUlang/RincianDaftarUlangController
        //Komite
        Route::resource('dasboard-komite', App\Http\Controllers\Bendahara\BendaharaKomiteController::class);
        // Pemasukkan Komite
        Route::get('/input-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'InputKomite'])->name('InputKomite');
        Route::resource('/pengeluaran-komite', App\Http\Controllers\Bendahara\KomitePengeluaranController::class);
        Route::POST('/copy-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'CopyKomite'])->name('CopyKomite');
        Route::POST('/reset-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'ResetKomite'])->name('ResetKomite');
        Route::POST('/bulk-update-komite', [\App\Http\Controllers\Bendahara\KeuanganRiwayatListController::class, 'BulkUpdate'])->name('BulkUpdate');
        Route::get('/list-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'ListDana'])->name('ListDana');
        Route::get('/pengaturan-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'PengaturanKomite'])->name('PengaturanKomite');
        Route::post('/list-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'ListDana'])->name('ListDana');
        // Pembayaran Tunggakan
        Route::get('/tunggakan-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'TunggakanSiswa'])->name('TunggakanSiswa');
        Route::POST('/tunggakan-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'TunggakanSiswa'])->name('TunggakanSiswa');
        Route::POST('/pembayaran-tunggakan-komite', [\App\Http\Controllers\Bendahara\BendaharaKomiteController::class, 'PembayaranTunggakanKomite'])->name('PembayaranTunggakanKomite');
        Route::resource('/dokumen-komite', App\Http\Controllers\Bendahara\KomiteDokumenController::class);
        Route::resource('/buku-kas-komite', App\Http\Controllers\Bendahara\BukukasKomiteController::class);
        // BOS
        Route::resource('pemasukkan-bos', App\Http\Controllers\Bendahara\BendaharaBosController::class);
        Route::resource('pengeluaran-bos', \App\Http\Controllers\Bendahara\BOS\TransaksaksiPengeluaranBOSController::class)->middleware(['auth', 'verified']);
        Route::resource('buku-kas-bos', \App\Http\Controllers\Bendahara\BOS\BukuKasBOSController::class)->middleware(['auth', 'verified']);
        // PIP
        Route::resource('pemasukkan-pip', \App\Http\Controllers\Bendahara\PIP\PemasukkanBendaharaPipController::class)->middleware(['auth', 'verified']);
        Route::POST('pemasukkan-pip-anggaran', [\App\Http\Controllers\Bendahara\PIP\PemasukkanBendaharaPipController::class, 'PIPAnggaran'])->name('pip.anggaran.update');
        Route::resource('pengeluaran-pip', \App\Http\Controllers\Bendahara\PIP\PengeluaranBendaharaPipController::class)->middleware(['auth', 'verified']);
        Route::resource('penerima-pip', \App\Http\Controllers\Bendahara\PIP\DataPenerimaPipController::class)->middleware(['auth', 'verified']);
        Route::delete('/penerima-pip/{penerima_pip}', [\App\Http\Controllers\Bendahara\PIP\DataPenerimaPipController::class, 'DeletPenerima'])->name('penerima.pip.delete');

        // CSR
        Route::resource('pemasukkan-csr', \App\Http\Controllers\Bendahara\CSR\PemasukkanCSRController::class)->middleware(['auth', 'verified']);
        Route::resource('pengeluaran-csr', \App\Http\Controllers\Bendahara\CSR\PengeluaranCSRController::class)->middleware(['auth', 'verified']);
        Route::resource('buku-kas-csr', \App\Http\Controllers\Bendahara\CSR\BukuKasCSRController::class)->middleware(['auth', 'verified']);
        //KAS Umum
        Route::resource('/buku-kas-umum', App\Http\Controllers\Bendahara\KasUmum\BendaharaKasUmumController::class); // Belum
        Route::POSt('laporan-buku-kas-umum', [\App\Http\Controllers\Bendahara\KasUmum\BendaharaKasUmumController::class, 'LaporanKasUmum'])->name('laporan.buku.kas.umum');
        // Tabungan
        Route::prefix('/tabungan')->group(
            function () {
                Route::resource('', App\Http\Controllers\Bendahara\BendaharaTabunganController::class)->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->names([
                    'index' => 'bendahara.tabungan.index',
                    'create' => 'bendahara.tabungan.create',
                    'store' => 'bendahara.tabungan.store',
                    'show' => 'bendahara.tabungan.show',
                    'edit' => 'bendahara.tabungan.edit',
                    'update' => 'bendahara.tabungan.update',
                    'destroy' => 'bendahara.tabungan.destroy',
                ]);
                Route::get('/tabungan-siswa', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'TabunganSiswa'])->name('TabunganSiswa');
                Route::get('/data-tabungan', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'DataTabungan'])->name('DataTabungan');
                Route::get('/transfer-pembayaran', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'TransferPembayaran'])->name('TransferTabungan');
                Route::get('/laporan', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanTabungan'])->name('LaporanTabungan');
                Route::POST('/laporan', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanBulananTabungan'])->name('LaporanBulananTabungan');
                Route::POST('/laporan/bulanan', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanBulananTabungan'])->name('LaporanBulananTabungan');
                Route::POST('/laporan/bulanan/ajax', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanBulananTabunganajax'])->name('LaporanBulananTabunganajax');
                Route::POST('/laporan/bulanan/siswa-ajax', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'LaporanBulananTabunganSiswaajax'])->name('LaporanBulananTabunganSiswaajax');
                Route::get('/riwayat-tabungan/{id}', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'RiwayatTabungan'])->name('RiwayatTabungan');
                Route::get('/cetak', [App\Http\Controllers\Bendahara\BendaharaTabunganController::class, 'CetakPdf'])->name('CetakPdf');
            }
        );
        Route::prefix('/study-tour')->group(
            function () {
                Route::resource('data-study-tour', App\Http\Controllers\Bendahara\BendaharaStudyTourController::class)
                    ->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])
                    ->parameters(['' => 'study_tour']) // Tambahkan nama parameter
                    ->names([
                        'index' => 'bendahara.studytour.index',
                        'create' => 'bendahara.studytour.create',
                        'store' => 'bendahara.studytour.store',
                        'show' => 'bendahara.studytour.show',
                        'edit' => 'bendahara.studytour.edit',
                        'update' => 'bendahara.studytour.update',
                        'destroy' => 'bendahara.studytour.destroy',
                    ]);
                Route::resource('/riwayat', App\Http\Controllers\Bendahara\RiwayatStudyTourController::class)->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->names([
                    'index' => 'RiwayatStudyTour.index',
                    'create' => 'RiwayatStudyTour.create',
                    'store' => 'RiwayatStudyTour.store',
                    'show' => 'RiwayatStudyTour.show',
                    'edit' => 'RiwayatStudyTour.edit',
                    'update' => 'RiwayatStudyTour.update',
                    'destroy' => 'RiwayatStudyTour.destroy',
                ]);

                Route::get('study-tour-setting', [App\Http\Controllers\Bendahara\BendaharaStudyTourController::class, 'SettingStudyTour'])->name('SettingStudyTour');
                Route::get('input-study-tour', [App\Http\Controllers\Bendahara\BendaharaStudyTourController::class, 'InputStudyTour'])->name('InputStudyTour');
                Route::get('data-pembayaran-study-tour', [App\Http\Controllers\Bendahara\BendaharaStudyTourController::class, 'DataStudyTour'])->name('DataStudyTour');
            }


        );
        // Riwayat dan List Pembayaran Komite
        Route::resource('keuangan-riwayat-list', App\Http\Controllers\Bendahara\KeuanganRiwayatListController::class);
        Route::resource('keuangan-list', App\Http\Controllers\Bendahara\KeuanganListController::class);
        // Route::POST('/keungan-insert-list', [\App\Http\Controllers\Bendahara\KeuanganListController::class, 'KeuanganInsertList'])->name('KeuanganInsertList');
        Route::resource('transfer-pembayaran', \App\Http\Controllers\Bendahara\Transfer\TransferPembayaranController::class)->middleware(['auth', 'verified']);
    }
);
Route::resource('/testpage', TestpageController::class);
Route::get('/phpinfo', function () {
    phpinfo();
});
//Upload
Route::middleware('auth')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->prefix('/upload')->group(
    function () {
        //Gambar
        Route::POST('/logo', [UploadFileController::class, 'UploadLogo'])->name('UploadLogo');
        Route::POST('/profile', [UploadFileController::class, 'UploadLogo'])->name('UploadLogo');
        Route::POST('/detail-siswa', [\App\Http\Controllers\UploadFileController::class, 'detailsiswa'])->name('detailsiswa');
        Route::POST('/detail-siswa-kelas', [ExcelController::class, 'SiswaInKelas'])->name('SiswaInKelas');
        Route::POST('/detail-guru', [UploadFileController::class, 'detailguru'])->name('detailguru');

        Route::POST('/materi', [UploadFileController::class, 'UploadLogo'])->name('UploadLogo');
        Route::POST('/kreditpoint', [UploadFileController::class, 'UploadLogo'])->name('UploadLogo');
        Route::POST('/foto-guru/{id}', [UploadFileController::class, 'UploadFotoGuru'])->name('UploadFotoGuru');
        //Excel
        Route::post('/upload-excel', [ExcelController::class, 'uploadExcel'])->name('upload.excel'); // Upload Siswa
        Route::POST('/testpage/uploader', [\App\Http\Controllers\TestpageController::class, 'Uploader'])->name('testpage.excel');
        Route::GET('/upload-excel', [ExcelController::class, 'showForm'])->name('upload.excel.form');
        // Upload Target Siswa PPDB
        Route::POST('upload-target-peserta-sosialisasi', [ExcelController::class, 'UploadTargetSosialisasi'])->name('upload.target.sosialisasi');
    }
);
Route::prefix('/ekinerja')->group(
    function () {
        //Data
    }
);
Route::middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->prefix('/dokument-project')->group(
    function () {

        Route::resource('dokumentasi', \App\Http\Controllers\Program\Dokumentasi\DataDokumentasiController::class);
    }
);

// Proses Absen sebaiknya tanpa auth
Route::GET('absensi/absen-siswa-ajax', [App\Http\Controllers\Absensi\EabsenController::class, 'IndexAjax'])->name('absensi.index.ajax');
Route::POST('absensi/store-ajax', [App\Http\Controllers\Absensi\EabsenController::class, 'storeAjax'])->name('absensi.ajax');
// Absensi Guru
Route::resource('absensi/absen-guru', \App\Http\Controllers\Absensi\EabsenGuruController::class)->middleware(['auth', 'verified']);
Route::GET('absensi/absen-guru-ajax', [App\Http\Controllers\Absensi\EabsenGuruController::class, 'IndexGuruAjax'])->name('absensi.guru.index.ajax');
Route::POST('absensi/store-guru-ajax', [App\Http\Controllers\Absensi\EabsenGuruController::class, 'storeAjax'])->name('absensi.store.guru.ajax');
Route::get('/absensi/list', function () {
    $absensi = \App\Models\Absensi\Eabsen::with('detailsiswa')
        ->whereDate('created_at', Carbon::today()) // ✅ Filter hari ini saja
        ->orderByDesc('created_at')
        ->take(10) // atau semua
        ->get()
        ->map(function ($item) {
            return [
                'nama' => $item->detailsiswa->nama_siswa ?? '-',
                'nis' => $item->detailsiswa->nis ?? '-',
                'waktu' => $item->created_at->format('Y-m-d H:i:s'),
            ];
        });

    return response()->json($absensi);
})->name('absensi.list');
Route::get('/absensi/list-guru', function () {
    $absensi = \App\Models\Absensi\EabsenGuru::with('guru')
        ->whereDate('created_at', Carbon::today()) // ✅ Filter hari ini saja
        ->orderByDesc('created_at')
        ->get()
        ->map(function ($item) {
            $jamMasuk = Carbon::parse($item->created_at->format('Y-m-d') . ' 07:00:00');
            $waktuAbsen = $item->created_at;
            $terlambat = $waktuAbsen->greaterThan($jamMasuk)
                ? $waktuAbsen->diff($jamMasuk)->format('%H:%I:%S')
                : null;

            return [
                'nama_guru'  => $item->guru->nama_guru ?? '-',
                'kode_guru'  => $item->guru->kode_guru ?? '-',
                'waktu'      => $waktuAbsen->format('Y-m-d H:i:s'),
                'terlambat'  => $terlambat ?? 'Tepat Waktu',
            ];
        });

    return response()->json($absensi);
})->name('absensi.list.guru');


Route::middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->prefix('/absensi')->name('absensi.')->group(
    function () {
        // Absensi Siswa
        Route::resource('/data-absensi-siswa', App\Http\Controllers\Absensi\EabsenController::class);
        Route::POST('absen-siswa-manual', [App\Http\Controllers\Absensi\EabsenController::class, 'absenManual'])->name('AbsenManual');
        Route::GET('absen-siswa', [App\Http\Controllers\Absensi\EabsenController::class, 'absensiSiswa'])->name('absensiSiswa');
        Route::GET('rekap-absensi-cetak', [App\Http\Controllers\Absensi\EabsenController::class, 'RekapAbsensicetak'])->name('rekap.absensi.cetak');
        Route::POST('riwayat-absensi-siswa', [App\Http\Controllers\Absensi\EabsenController::class, 'RiwayatAbsenGlobalSiswa'])->name('riwayat.absensi.global');
        // Absensi Guru
        Route::POST('data-absensi-guru', [App\Http\Controllers\Absensi\EabsenController::class, 'storeAbsensiGuru'])->name('absen.guru.store');
        Route::GET('absen-guru', [App\Http\Controllers\Absensi\EabsenController::class, 'absensiGuru'])->name('scan.guru');
        Route::resource('ijin-digital-siswa', \App\Http\Controllers\Absensi\DataIjinDigitalController::class);
        //Versi ajax

    }
);
Route::middleware('auth')->group(function () {
    Route::GET('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Waka Kurikulum
Route::prefix('/waka-kurikulum')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('nilai-siswa', App\Http\Controllers\Learning\EnilaiController::class);
        Route::resource('kaldik', EkaldikController::class);
        Route::resource('jurnal-mengajar', App\Http\Controllers\WakaKurikulum\Elearning\KurikulumJurnalMengajarController::class);
        Route::resource('materi-ajar', App\Http\Controllers\WakaKurikulum\Elearning\KurikulumMateriAjarController::class);
        Route::resource('kkm', App\Http\Controllers\Learning\EmateriController::class);
        Route::resource('data-kkm', App\Http\Controllers\WakaKurikulum\Elearning\KurikulumDataKKMController::class);
        Route::post('/data-kkm/update', [App\Http\Controllers\WakaKurikulum\Elearning\KurikulumDataKKMController::class, 'updateKKM'])->name('waka.kurikulum.update-kkm');
        //Daftar Nilai
        Route::resource('data-nilai-uh', App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUHController::class);
        Route::get('data-nilai-uh/{mapel_id}/{kelas_id}', [App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUHController::class, 'show'])->name('data-nilai-uh.show');
        Route::resource('data-nilai-tugas', App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiTugasController::class);
        Route::get('data-nilai-tugas/{mapel_id}/{kelas_id}', [App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiTugasController::class, 'show'])->name('data-nilai-tugas.show');
        Route::resource('data-nilai-pts-pas', App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiPTSPASController::class);
        Route::resource('data-nilai-ujian', App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUjianController::class);
        Route::delete('data-nilai-ujian', [App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurikulumNilaiUjianController::class, 'destroy'])->name('data-nilai-ujian.destroy');
        Route::resource('data-peserta-ujian', \App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjianController::class);
        Route::delete('hapus-semua-nilai-ujian', [App\Http\Controllers\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjianController::class, 'HapusSemuaPeserta'])->name('hapus-semua-nilai-ujian.destroy');

        Route::resource('jadwal-pelajaran', App\Http\Controllers\Jadwal\JadwalPelajaranController::class);
        Route::get('/jadwal-pelajaran-blanko', [App\Http\Controllers\Jadwal\JadwalPelajaranController::class, 'JadwalBlank'])->name('jadwal.blanko');
        Route::get('/jadwal-pelajaran-duplikat', [App\Http\Controllers\Jadwal\JadwalPelajaranController::class, 'JadwalDuplikat'])->name('jadwal.duplikat');
        Route::post('/update-jadwal/{id}', [App\Http\Controllers\Jadwal\JadwalPelajaranController::class, 'updateJadwal']);

        //Perangkat Test
        Route::resource('perangkat-test', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatTestController::class);
        // Route::resource('peserta-test', App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class);
        Route::resource('peserta-test', App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class);
        Route::resource('tempat-duduk-test', App\Http\Controllers\WakaKurikulum\Perangkat\TempatDudukTestController::class);
        Route::resource('kartu-test', App\Http\Controllers\WakaKurikulum\Perangkat\KartuTestController::class);
        Route::resource('berita-acara', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatBeritaAcaraController::class);
        Route::resource('daftar-hadir', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatDaftarHadirController::class);
        Route::resource('tempat-duduk', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatTempatDudukController::class);
        Route::get('bulk-tempat-duduk', [App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class, 'BulkTempatDuduk'])->name('bulk.tempat.duduk');
        Route::resource('nomor-meja', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatNomorMejaController::class);
        Route::resource('jadwal-test', App\Http\Controllers\WakaKurikulum\Perangkat\JadwalTestController::class);
        Route::post('jadwal-test/update', [App\Http\Controllers\WakaKurikulum\Perangkat\JadwalTestController::class, 'update'])->name('waka.jadwal.update');
        Route::get('jadwal-reset', [App\Http\Controllers\WakaKurikulum\Perangkat\JadwalTestController::class, 'Resset'])->name('waka.jadwal.Resset');
        Route::delete('jadwal-test/{jadwal_test}', [\App\Http\Controllers\WakaKurikulum\Perangkat\JadwalTestController::class, 'destroy'])->name('jadwal-test.destroy');
        Route::resource('peraturan-test', App\Http\Controllers\WakaKurikulum\Perangkat\PeraturanTestController::class);
        Route::resource('ruang-test', App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatRuangTestController::class);
        Route::post('update-ruang', [App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatRuangTestController::class, 'UpdateRuangan'])->name('update.ruangan.test');
        Route::get('reset-ruang', [App\Http\Controllers\WakaKurikulum\Perangkat\PerangkatRuangTestController::class, 'resetRuangan'])->name('reset.ruangan.test');
        Route::match(['get'], 'peserta-test-copy', [App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class, 'PesertaTest'])->name('PesertaTest');
        //Update jax Ruangann
        Route::post('update-ruang-test', [App\Http\Controllers\WakaKurikulum\Perangkat\PesertaTestController::class, 'updateRuangTest'])->name('update.ruang.test');
        //Perangkat Guru Piket
        Route::resource('jadwal-piket-guru', App\Http\Controllers\WakaKurikulum\JadwalPiket\DataJadwalPiketController::class);
        Route::resource('tugas-piket-guru', App\Http\Controllers\WakaKurikulum\JadwalPiket\TugasGuruController::class);
        Route::get('tugas-piket-guru-sekarang', [App\Http\Controllers\WakaKurikulum\JadwalPiket\TugasGuruController::class, 'TugasNow'])->name('tugas.guru,sekarang');
        // Perangkat Kelulusan
        Route::prefix('kelulusan')->group(
            function () {
                Route::resource('peserta-kelulusan', App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class);
                Route::post('peserta-kelulusan', [App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class, 'updatePesertaKelulusan'])->name('update.peserta.kelulusan');
                Route::post('reset-kelulusan', [App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class, 'resetPesertaKelulusan'])->name('reset.peserta.kelulusan');
                Route::post('ubah-status-kelulusan', [App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class, 'StatusPesertaKelulusan'])->name('status.peserta.kelulusan');
                Route::post('tanggal-kelulusan', [App\Http\Controllers\WakaKurikulum\Kelulusan\PesertaKelulusanController::class, 'tanggalKelulusan'])->name('tanggal.kelulusan');
                Route::resource('pengumuman-kelulusan', \App\Http\Controllers\WakaKesiswaan\Pengumuman\PengumumanKelulusanController::class);
                Route::resource('surat-kelulusan', \App\Http\Controllers\WakaKurikulum\Surat\SuratKelulusanController::class);
                Route::resource('nilai-raport-kelulusan', App\Http\Controllers\WakaKurikulum\Kelulusan\NilaiSemesterKelulusanController::class);
                Route::get('/nilai-raport-kelulusan/{detailsiswa_id}', [App\Http\Controllers\WakaKurikulum\Kelulusan\NilaiSemesterKelulusanController::class, 'show'])->name('raport.show');
            }
        );

        Route::resource('e-ijazah', \App\Http\Controllers\Program\EIjazah\EIjazahSiswaController::class)->middleware(['auth', 'verified']);
    }
);

Route::prefix('waka-kesiswaan')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        //Ekstra
        Route::resource('ekstrakurikuler', App\Http\Controllers\WakaKesiswaan\Ekstra\EkstraController::class);
        Route::resource('peserta-ekstrakurikuler', App\Http\Controllers\WakaKesiswaan\Ekstra\PesertaEkstraController::class);
        Route::resource('nilai-ekstrakurikuler', App\Http\Controllers\WakaKesiswaan\Ekstra\NilaiEkstraController::class);
        Route::post('nilai-ekstrakurikuler-bulk', [App\Http\Controllers\WakaKesiswaan\Ekstra\NilaiEkstraController::class, 'UpdateBulkNilai'])->name('update.bulk.nilai.ekstra');
        Route::resource('riwayat-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\RiwayatPendaftaranPPDBController::class);
        Route::resource('daftar-hadir-ekstrakurikuler', App\Http\Controllers\WakaKesiswaan\Ekstra\DaftarHadirEkstraController::class);
        Route::resource('data-peserta-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\WakaKesiswaanDataPesertaPPDBController::class);
        Route::resource('/pengumuman-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\PengumumanPPDBController::class);
        Route::resource('kepanitiaan-ppdb', App\Http\Controllers\WakaKesiswaan\PPDB\KepanitianPPDBController::class);
    }
);


Route::post('/clear-session', function (Request $request) {
    $keys = $request->input('keys', []); // Ambil array 'keys', defaultnya adalah array kosong
    foreach ($keys as $key) {
        session()->forget($key);
    }
    return response()->json(['status' => 'success']);
})->name('clear.session');
//Waka Humas
//Waka Sarpras
Route::prefix('waka-sarpras')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('dashboard-sarpras', App\Http\Controllers\WakaSarpras\WakaSarprasController::class);
        Route::resource('inventaris-sarpras', App\Http\Controllers\WakaSarpras\Inventaris\EinventarisController::class);
        Route::resource('inventaris-vendor', App\Http\Controllers\WakaSarpras\Inventaris\InventarisVendorController::class);
        Route::resource('inventaris-ruangan', App\Http\Controllers\WakaSarpras\Inventaris\InventarisRuanganController::class);
        Route::resource('inventaris-kiba', App\Http\Controllers\WakaSarpras\Inventaris\KIBAController::class);
        Route::resource('inventaris-kibb', App\Http\Controllers\WakaSarpras\Inventaris\KIBBController::class);
        Route::resource('inventaris-kibc', App\Http\Controllers\WakaSarpras\Inventaris\KIBCController::class);
        Route::resource('inventaris-kibd', App\Http\Controllers\WakaSarpras\Inventaris\KIBDController::class);
        Route::resource('inventaris-kibe', App\Http\Controllers\WakaSarpras\Inventaris\KIBEController::class);
        Route::resource('inventaris-kibf', App\Http\Controllers\WakaSarpras\Inventaris\KIBFController::class);
        Route::resource('inventaris-vendor', App\Http\Controllers\WakaSarpras\Inventaris\InventarisVendorController::class);
        Route::resource('inventaris-in-ruangan', App\Http\Controllers\WakaSarpras\Inventaris\InventarisInRuanganController::class);
        Route::resource('pengajuan-inventaris-sarpras', App\Http\Controllers\WakaSarpras\Inventaris\InventarisPengajuanController::class);
    }
);

//E Kaldik
Route::resource('/ekaldik', EkaldikController::class)->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
Route::GET('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::GET('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/ckeditor/upload', function (Request $request) {
    if (!Auth::check()) { // Gunakan Auth::check() daripada auth()->check()
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'Unauthorized']], 403);
    }

    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/uploads', $filename);
        $url = asset('storage/uploads/' . $filename);
        return response()->json(["uploaded" => 1, "fileName" => $filename, "url" => $url]);
    }
    return response()->json(['uploaded' => 0, 'error' => ['message' => 'Upload gagal']]);
})->middleware('auth');

//Data CBT
Route::prefix('cbt')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::resource('data-test', \App\Http\Controllers\Program\CBT\CBTJadwalController::class);
        Route::resource('bank-soal', \App\Http\Controllers\Program\CBT\BankSoalController::class);
        // Rute untuk menerima data dari form
        Route::post('/test-cbt-mulai', [\App\Http\Controllers\Program\CBT\SoalCBTController::class, 'submitTestCbt'])->name('cbt.submit');
        // Route untuk halaman soal CBT
        Route::get('/test-cbt-soal/{id}', [\App\Http\Controllers\Program\CBT\SoalCBTController::class, 'showSoalCbt'])->name('role.program.cbt.cbt-soal');

        Route::get('/test-cbt-mulai', [\App\Http\Controllers\Program\CBT\SoalCBTController::class, 'submitTestCbt'])->name('cbt.test-cbt-mulai');
        Route::get('/selesai', [\App\Http\Controllers\Program\CBT\SoalCBTController::class, 'selesai'])->name('cbt.selesai');

        Route::resource('hasil-test', \App\Http\Controllers\Program\CBT\JawabanCBTController::class);
        Route::delete('hasil-test/{hasil_test}', [\App\Http\Controllers\Program\CBT\JawabanCBTController::class, 'destroy'])->name('hasil-test.destroy');

        Route::resource('analisis-test', \App\Http\Controllers\Program\CBT\AnalisisTestController::class);
        Route::resource('test-cbt', \App\Http\Controllers\Program\CBT\SoalCBTController::class); //
        Route::post('submit', [\App\Http\Controllers\Program\CBT\SoalCBTController::class, 'submit'])->name('cbt.submit');
        Route::post('autosave', [\App\Http\Controllers\Program\CBT\SoalCBTController::class, 'autosave'])->name('cbt.autosave')->withoutMiddleware(['auth', 'CekDataSekolah', 'token.check', 'verified']);
        Route::resource('program-remdial', \App\Http\Controllers\Program\CBT\ProgramRemidialController::class);
    }
);
// ini arah form data siswa kedepannya
Route::get('cbt', [\App\Http\Controllers\Program\CBT\SoalCBTController::class, 'index']);
Route::prefix('/aplikasi')->group(
    function () {
        Route::resource('tentang-aplikasi', \App\Http\Controllers\Aplikasi\Tentang\TentangAplikasiController::class);
        Route::resource('dokumentasi-aplikasi', \App\Http\Controllers\Aplikasi\Tentang\DokumentasiAplikasiController::class);
    }
);

// require __DIR__ . '/auth.php';
Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
    ->middleware('CekDataSekolah')->name('login'); // Pastikan hanya middleware ini yang diterapkan untuk login

Route::get('/lockscreen', [\App\Http\Controllers\LockscreenController::class, 'index'])->name('lockscreen');
Route::get('/admin/token', [\App\Http\Controllers\Admin\TokenController::class, 'index'])->name('admin.token.index');
Route::post('/admin/token/update', [\App\Http\Controllers\Admin\TokenController::class, 'update'])->name('admin.token.update');



// Khusus untuk admindev, gunakan middleware is_admindev tanpa token
Route::middleware(['auth', 'CekDataSekolah', 'verified', 'is_admindev'])->prefix('admindev')->group(function () {
    Route::resource('modul', \App\Http\Controllers\AdminDev\ModulController::class);
    // Route::resource('tokenapp', TokenController::class);
    Route::get('/tokenapp', [\App\Http\Controllers\AdminDev\TokenController::class, 'index'])->name('tokenapp.index')->middleware(['auth', 'CekDataSekolah', 'verified']);
    Route::post('/tokenapp', [\App\Http\Controllers\AdminDev\TokenController::class, 'update'])->name('tokenapp.update')->middleware(['auth', 'CekDataSekolah', 'verified']);
    Route::resource('control-program', \App\Http\Controllers\AdminDev\ControlMenuController::class)->middleware(['auth', 'verified']);
    Route::post('control-program/{control_program}', [\App\Http\Controllers\AdminDev\ControlMenuController::class, 'update'])->middleware(['auth', 'CekDataSekolah', 'verified'])->name('admindev.update.control');
    Route::PATCH('control-program-user/{id}', [\App\Http\Controllers\AdminDev\ControlMenuController::class, 'updateUser'])->middleware(['auth', 'CekDataSekolah', 'verified'])->name('admindev.user');
    Route::resource('progres-aplikasi', \App\Http\Controllers\AdminDev\ProgresAplikasiController::class)->middleware(['auth', 'verified']);
    Route::get('copy-fitur/{progres_aplikasi}', [\App\Http\Controllers\AdminDev\ProgresAplikasiController::class, 'CopyData'])->name('copy-fitur');
    Route::resource('svg-to-png', \App\Http\Controllers\AdminDev\SvgPngController::class)->middleware(['auth', 'verified']);
    Route::get('generate-karpel', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateKarpel'])->name('generate.karpel');
    Route::get('generate-nisn', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateNisn'])->name('generate.nisn');
    Route::get('generate-nisn-array', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateNisnArray'])->name('generate.nisn.array');
    Route::get('generate-cocard', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateCoCard'])->name('generate.cocard');
    Route::get('generate-sertifikat', [\App\Http\Controllers\AdminDev\SvgPngController::class, 'GenerateSertifikat'])->name('generate.sertifikat');

    Route::resource('control-program', \App\Http\Controllers\AdminDev\ControlMenuController::class)->middleware(['auth', 'verified']);
    Route::resource('data-kerjasama', \App\Http\Controllers\Paket\Kerjasama\DataKerjasamaController::class)->middleware(['auth', 'verified']);
    Route::resource('harga-paket', \App\Http\Controllers\Paket\Kerjasama\HargaPaketController::class)->middleware(['auth', 'verified']);
});
Route::get('/kirim-email', [App\Http\Controllers\EmailController::class, 'kirim']);
Route::get('/form-email', function () {

    $title = 'Data Seting Pengguna';
    $breadcrumb = 'Seting Pengguna Program / Data Seting Pengguna';
    return view('program.email.email_form', compact(
        'title',
        'breadcrumb',
    ));
});
// Whatsapp
Route::prefix('whatsapp')->group(
    // Route::prefix('whatsapp')->middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->group(
    function () {
        Route::post('start-session', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'storeSessionin']); //aslinya storeSession jika startsession gagal dikembalikan
        Route::post('update-session', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'updateSession']);
        // Proses
        Route::post('cek-pembayaran', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'CekPembayaran'])->name('whatsapp.cek.pembayaran');
        Route::post('cek-kehadiran', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'CekPembayaran'])->name('whatsapp.cek.kehadiran');
        Route::post('cek-nilai', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'CekPembayaran'])->name('whatsapp.cek.nilai');
        Route::post('cek-tabungan', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'CekPembayaran'])->name('whatsapp.cek.tabungan');

        Route::resource('whatsapp-control', \App\Http\Controllers\Whatsapp\WhatsappLogController::class);
        Route::resource('whatsapp-akun', \App\Http\Controllers\Whatsapp\WhatsAppSessionController::class);
        Route::post('/run-wa-server', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'runSilent']);
    }
);
Route::POST('kirim-media-grup', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'SendGroupMedia'])->name('kirim.media.grup'); // Menghapus sesi
Route::get('/get-groups-by-session', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'getGroupsBySession'])->name('get.groups.by.session');

Route::post('/run-wa-server', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'runServer'])->name('whatsapp.runserver'); //Mengaktifkan server dengan bat
Route::post('/restart-wa-server', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'restartServer'])->name('whatsapp.restartserver'); //Mengaktifkan server dengan bat
Route::post('/hapus-sesi-wa', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'hapusSession'])->name('whatsapp.hapussession'); // Menghapus sesi
Route::POST('membuat-akun-baru', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'AkaunBaru'])->name('AkaunBaru'); // Menghapus sesi
Route::get('/whatsapp/auto-reply', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'testAutoReply'])->name('whatsapp.autoreply');
Route::resource('whatsapp/penjadwalan', \App\Http\Controllers\Whatsapp\PenjadwalanPesanController::class); // Penjadwalan internal
Route::resource('whatsapp/penjadwalan-ppdb', \App\Http\Controllers\Whatsapp\PenjadwalanWhatsappPPDBController::class); // Penjadwalan Sosialisasi
// Route untuk ambil data siswa via AJAX (berdasarkan NIS)
Route::POST('/siswa/scan', [DetailsiswaController::class, 'getByNis'])->name('siswa.scan');
Route::resource('whatsapp/komunikasi', \App\Http\Controllers\Whatsapp\WhatsappKomunikasiController::class);
Route::GET('whatsapp/komunikasi-jemputan', [\App\Http\Controllers\Whatsapp\WhatsappKomunikasiController::class, 'jemputansiswa'])->name('whatsapp.jemputan.siswa'); // Menghapus sesi
Route::post('start-session', [\App\Http\Controllers\Whatsapp\WhatsAppSessionController::class, 'storeSession'])->name('whatsapp.start.session');
Route::middleware(['auth', 'CekDataSekolah', 'token.check', 'verified'])->get('whatsapp-qrcode', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'whatsappqrcode'])->name('whatsappqrcode');
Route::POST('get-anggota-group', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'GetMember'])->name('whatsapp.member');
Route::get('start-session', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'createSession'])->name('createSession');
Route::get('kirim-pesan', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'kirimpesan'])->name('kirimpesan');
Route::get('kirim-pesan-masal', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'kirimpesan'])->name('kirimpesan.masal');
Route::get('status', [\App\Http\Controllers\Whatsapp\WhatsAppController::class, 'getStatus'])->name('wa.status');



Route::get('/debug-session', function () {
    session()->put('from_device', 'HP');
    return response()->json([
        'session' => session()->all()
    ]);
});
Route::resource('kritik-saran', \App\Http\Controllers\Tools\KirikdanSaran\KritikSaranController::class)->middleware(['auth', 'verified']);
