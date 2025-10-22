<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class EkstraServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/ekstra.php'));
    }
}