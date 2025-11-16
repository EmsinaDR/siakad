<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected function tokensMatch($request)
    {
        // Jika request adalah API atau WhatsApp, lewati CSRF
        if ($request->is('whatsapp/*')) {
            return true;
        }

        return parent::tokensMatch($request);
    }
    protected $except = [
        // '/api/start-session',
        // '/api/send-message',
        // '/api/logout',
        // // 'login',
        // '/api/session-status',
        // 'whatsapp/test-auto-reply',
        // 'whatsapp/auto-reply',
        // 'api/*' // (Opsional, jika ada API lain yang butuh pengecualian)
    ];
}
/*
protected $except = [
    '/api/start-session',
    '/api/send-message',
    '/api/logout',
    '/api/session-status',
    'whatsapp/auto-reply',
    'api/*'
];

*/
/*



php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
cls

composer dump-autoload



php artisan migrate:fresh --seed


composer dump-autoload

*/