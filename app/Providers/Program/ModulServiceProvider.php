<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class ModulServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/modul.php'));
    }
}