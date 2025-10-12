<?php

namespace App\Providers\Program;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FrontServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        Route::middleware('web')->group(base_path('routes/program/front.php'));
    }
}
