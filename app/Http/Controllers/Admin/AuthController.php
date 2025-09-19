<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $login = $request->login;
        $password = $request->password;

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email'
            : (is_numeric($login) ? 'mobile_number' : 'username');

        $user = User::where($fieldType, $login)->first();

        if (!$user) {
            return back()->withErrors(['login' => 'Invalid login credentials']);
        }

        if (!$user->can_login) {
            return back()->withErrors(['login' => 'You are not allowed to login']);
        }

        if (!in_array($user->status, ['active'])) {
            return back()->withErrors(['login' => 'Your account is not active']);
        }

        $allowedTypes = ['user', 'admin', 'it', 'tester', 'employee'];
        if (!in_array($user->type, $allowedTypes)) {
            return back()->withErrors(['login' => 'You are not allowed to login']);
        }

        if (Auth::attempt([$fieldType => $login, 'password' => $password], $request->remember_me)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login' => 'Invalid login credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
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
