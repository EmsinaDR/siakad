<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErombelController extends Controller
{
    //
    public function index()
    {
        //
        $data = '';
        $title = 'E Tapel';
        $breadcrumb = 'aaa / aa';
        return view('admin.user.erombel', ['title' => $title, 'data' => $data, 'breadcrumb' => $breadcrumb]);
    }
}
