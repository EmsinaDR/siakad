<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class PpdbServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/ppdb.php'));
    }
}