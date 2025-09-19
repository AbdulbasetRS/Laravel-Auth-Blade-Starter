<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        return response()->json(200);
    }

    /* ========================================================================== */

    // Register
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        return response()->json(200);
    }

    /* ========================================================================== */

    // Password Reset
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        return response()->json(200);
    }

    /* ========================================================================== */

    // Reset Password
    public function showResetPasswordForm()
    {
        return view('admin.auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        return response()->json(200);
    }

    /* ========================================================================== */

    // Email Verification
    public function verificationNotice()
    {
        return view('admin.auth.verification-notice');
    }

    public function verificationVerify()
    {
        return view('admin.auth.verification-verify');
    }

    public function sendVerificationNotification(Request $request)
    {
        return response()->json(200);
    }
}