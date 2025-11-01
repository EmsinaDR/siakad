<?php

namespace App\Providers\Program;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
// App\Providers\Program\AbsensiServiceProvider
class AbsensiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // $this->loadRoutesFrom(base_path('routes/program/tools.php'));
        // Route::middleware('web')->group(base_path('routes/program/absensi.php'));
        // $this->loadRoutesFrom(base_path('routes/program/absensi.php'));
        Route::middleware(['web'])->group(base_path('routes/program/absensi.php'));

    }
}
