<?php

namespace App\Providers\Program;

use Illuminate\Support\ServiceProvider;

class VoteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(base_path('routes/program/vote.php'));
    }
}