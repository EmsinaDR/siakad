<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // public function login(Request $request)
    // {

    //     if (Auth::check()) {
    //         return redirect('/');
    //     } else {
    //         return view('login.index', ['title' => 'Login - Aplikasi SIAKAD SMP Cipta IT']);
    //         // return view('login/index');
    //         //  return ('login');
    //     }
    //     // return ('login');
    // }

    // public function actionlogin(Request $request)
    // {
    //     $data = [
    //         'email' => $request->input('email'),
    //         'password' => $request->input('password'),
    //     ];
    //     if (Auth::Attempt($data)) {
    //         // return redirect('show');
    //         // dd(Auth::user()->role);
    //         // if (Auth::user()->role == 'Administrator') {;
    //         //     return redirect('dataguru');
    //         // } else {
    //         //     return redirect('show');
    //         // }




    //         return redirect('dataguru');
    //     } else {
    //         // session::flash('error', 'Email atau Password Salah');
    //         return redirect('/login');
    //     }
    // }

    // public function actionlogout()
    // {
    //     Auth::logout();
    //     return redirect('/login');
    // }
}
