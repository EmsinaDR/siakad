<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LockscreenController extends Controller
{
    public function index()
    {
        if (Auth::user()->posisi !== 'Admindev') {

            return view('lockscreen');
        }
        return redirect()->route('tokenapp.index');
    }
}
