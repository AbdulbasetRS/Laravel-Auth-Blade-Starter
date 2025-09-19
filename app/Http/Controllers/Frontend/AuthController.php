<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function register()
    {
        return view('admin.auth.register');
    }

    public function dashboard()
    {
        return view('admin.auth.dashboard');
    }

    public function logout()
    {
        return view('admin.auth.logout');
    }

}