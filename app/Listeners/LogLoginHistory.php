<?php
// app/Listeners/LogLoginHistory.php
namespace App\Listeners;

use App\Models\Admin\RiwayatLogin;
use Illuminate\Auth\Events\Login;
use App\Models\LoginHistory;
use Illuminate\Support\Facades\Request;

class LogLoginHistory
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        RiwayatLogin::create([
            'user_id' => $event->user->id,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
            'logged_in_at' => now(),
        ]);
    }
}
