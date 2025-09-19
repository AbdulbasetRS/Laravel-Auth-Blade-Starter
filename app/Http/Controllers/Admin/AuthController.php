<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('frontend.auth.login');
    }

    public function register()
    {
        return view('frontend.auth.register');
    }

    public function forgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    public function resetPassword()
    {
        return view('frontend.auth.reset-password');
    }
}