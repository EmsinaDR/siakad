<?php

namespace App\Providers\Program;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PremiumServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware(['web', 'auth']) // kasih middleware 'web' biar session/auth aktif
            // ->group(base_path('routes/webx.php'));
            ->group(base_path('routes/program/premium.php'));
        // $this->loadRoutesFrom(base_path('routes/program/premium.php'));
    }
}
