<?php

// namespace App\Providers;

// use Illuminate\Support\Facades\Route;
// use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

// class RouteServiceProvider extends ServiceProvider
// {
//     /**
//      * Bootstrap any application services.
//      */
//     public function boot(): void
//     {
//         $this->routes(function () {
//             $admin = 1;
//             Route::middleware('web')->group(base_path('routes/web.php'));

//             if ($admin === 1) {
//                 Route::middleware('web')->group(base_path('routes/webx.php'));
//             }
//             Route::middleware('web')->group(base_path('routes/program/perpustakaan.php')); // 👈 load file tambahan
//             $this->loadRoutesFrom(base_path('routes/program/bk.php'));
//             $this->loadRoutesFrom(base_path('routes/program/bendahara/komite.php'));
//             $this->loadRoutesFrom(base_path('routes/program/bendahara/bos.php'));
//             $this->loadRoutesFrom(base_path('routes/program/bendahara/tabungan.php'));

//             $this->loadRoutesFrom(base_path('routes/program/laboratorium.php'));
//             $this->loadRoutesFrom(base_path('routes/program/ekstrakurikuler.php'));
//             $this->loadRoutesFrom(base_path('routes/program/walikelas.php'));
//             $this->loadRoutesFrom(base_path('routes/vendor/atadev.php'));
//             $this->loadRoutesFrom(base_path('routes/program/absensi.php'));
//             $this->loadRoutesFrom(base_path('routes/program/admin.php'));
//             $this->loadRoutesFrom(base_path('routes/program/tools.php'));
//             $this->loadRoutesFrom(base_path('routes/program/bukutamu.php'));
//             $this->loadRoutesFrom(base_path('routes/program/dokumentasi.php'));
//             $this->loadRoutesFrom(base_path('routes/program/whatsapp.php'));
//             $this->loadRoutesFrom(base_path('routes/program/rapat.php'));
//             $this->loadRoutesFrom(base_path('routes/program/wakakurikikulum.php'));
//             $this->loadRoutesFrom(base_path('routes/program/waka/wakakurikikulum.php'));
//             $this->loadRoutesFrom(base_path('routes/program/waka/wakakesiswaan.php'));
//             $this->loadRoutesFrom(base_path('routes/program/waka/wakasarpras.php'));
//             $this->loadRoutesFrom(base_path('routes/program/ppdb.php'));
//             $this->loadRoutesFrom(base_path('routes/program/kelulusan.php'));
//             $this->loadRoutesFrom(base_path('routes/api.php'));
//         });
//     }
// }

namespace App\Providers;

use App\Models\AdminDev\Modul;
use App\Models\Admin\Identitas;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /** * Bootstrap any application services. */ public function boot(): void
    {
        $this->routes(function () {
            // $Identitas = Identitas::first();
            // if ($Identitas->paket === 'Kerjasama') {
            //     $apps = Modul::where('is_active', 1)->get();
            //     // if ($apps->count() > 0) {
            //     //     foreach ($apps as $app) {
            //     //         if (class_exists($app->provider_class)) {
            //     //             $this->app->register($app->provider_class);
            //     //         
        $this->loadRoutesFrom(base_path('routes/program/surat.php'));

        $this->loadRoutesFrom(base_path('routes/program/pembina-osis.php'));

        $this->loadRoutesFrom(base_path('routes/program/shalat-jamaah.php'));

        $this->loadRoutesFrom(base_path('routes/program/buku-tamu.php'));

        $this->loadRoutesFrom(base_path('routes/program/supervisi.php'));

        $this->loadRoutesFrom(base_path('routes/program/pkks.php'));

        $this->loadRoutesFrom(base_path('routes/program/kepala-sekolah.php'));

        $this->loadRoutesFrom(base_path('routes/program/wali-kelas.php'));

        $this->loadRoutesFrom(base_path('routes/program/prestasi.php'));

        $this->loadRoutesFrom(base_path('routes/program/elearning.php'));

        $this->loadRoutesFrom(base_path('routes/program/kepala-tata-usaha.php'));

        $this->loadRoutesFrom(base_path('routes/program/vote.php'));

        $this->loadRoutesFrom(base_path('routes/program/template-dokumen.php'));
}
            //     //     }
            //     // }
            // }
        });
    }
}
