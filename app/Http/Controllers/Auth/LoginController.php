<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dasboard';

    // protected $redirectTo = '/dashboard';
    protected function authenticated(Request $request, $user)
    {
        // Cek posisi / role
        if ($user->posisi === 'AdminDev') {
            return redirect('/admindev/tokenapp');
        } elseif ($user->role === 'Guru') {
            return redirect('/dashboard');
        } elseif ($user->role === 'siswa') {
            return redirect('/siswa/home');
        }

        // Default fallback
        return redirect($this->redirectTo);
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
