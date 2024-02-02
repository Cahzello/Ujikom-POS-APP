<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoutingController extends Controller
{
    public function index (Request $request)
    {
        return view('dashboard', [
            'isLogin' => false,
            'active' => 'dashboard'
        ]);

    }

    public function login ()
    {
        return view('login', [
            'isLogin' => true
        ]);
    }

    public function register ()
    {
        return view('register', [
            'isLogin' => true
        ]);
    }

}
