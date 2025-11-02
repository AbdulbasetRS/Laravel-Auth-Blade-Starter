<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginService extends BaseUserAuthService
{
    public function attemptCredentialsLogin(string $identifier, string $password, Request $request, bool $remember = false): User
    {
        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email'
            : (is_numeric($identifier) ? 'mobile_number' : 'username');

        $user = User::where($fieldType, $identifier)->first();

        if (! $user) {
            throw new InvalidCredentialsException('invalid_credentials');
        }

        // Check status + type
        $this->assertUserAllowed($user);

        // حاولنا نسجل الدخول فعلياً
        if (Auth::attempt([$fieldType => $identifier, 'password' => $password], $remember)) {
            // regenerate session
            $request->session()->regenerate();

            return $user;
        }

        throw new InvalidCredentialsException('invalid_credentials');
    }
}
