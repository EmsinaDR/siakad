<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class SetDynamicAppUrl
{
    public function handle($request, Closure $next)
    {
        $base = $request->getSchemeAndHttpHost();

        // Override URL app & asset runtime
        Config::set('app.url', $base);
        Config::set('app.asset_url', $base);

        return $next($request);
    }
}
