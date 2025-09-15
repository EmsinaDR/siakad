<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class EkstrakurikulerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/ekstrakurikuler.php'));
    }
}