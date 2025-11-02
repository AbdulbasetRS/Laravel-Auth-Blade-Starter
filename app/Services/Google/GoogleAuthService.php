<?php

namespace App\Services\Google;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\AuthProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthService
{
    public function redirect()
    {
        return Socialite::driver('google')
            // ->scopes(['https://www.googleapis.com/auth/drive.file', 'email', 'profile'])
            ->with([
                'access_type' => 'offline',
                'prompt' => 'consent select_account',
            ])
            ->redirect();
    }

    public function handleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // هل المستخدم مربوط بالفعل بمزود Google؟
            $provider = AuthProvider::where('provider_name', 'google')
                ->where('provider_user_id', $googleUser->getId())
                ->first();

            if ($provider) {
                $user = $provider->user;
            } else {
                $user = User::where('email', $googleUser->getEmail())->first();

                if (! $user) {
                    $user = User::create([
                        'username' => Str::slug($googleUser->getName()).'-'.Str::random(4),
                        'slug' => Str::slug($googleUser->getName()).'-'.Str::random(6),
                        'email' => $googleUser->getEmail(),
                        'password' => bcrypt(Str::random(12)),
                        'status' => UserStatus::Active,
                        'type' => UserType::User,
                        'can_login' => true,
                    ]);
                }

                AuthProvider::updateOrCreate(
                    [
                        'provider_name' => 'google',
                        'provider_user_id' => $googleUser->getId(),
                    ],
                    [
                        'user_id' => $user->id,
                        'provider_access_token' => $googleUser->token,
                        'refresh_token' => $googleUser->refreshToken ?? null,
                        'token_expires_at' => $googleUser->expiresIn
                            ? Carbon::now()->addSeconds($googleUser->expiresIn)
                            : null,
                        'email' => $googleUser->getEmail(),
                        'name' => $googleUser->getName(),
                        'avatar' => $googleUser->getAvatar(),
                    ]
                );
            }

            // ⚠️ نعمل نفس التحقق اللى فى login العادي
            if (! $user->can_login) {
                return null;
                // return redirect()->route('admin.login')->with('error', 'You are not allowed to login');
            }

            if ($user->status !== UserStatus::Active) {
                return null;
                // return redirect()->route('admin.login')->with('error', 'Your account is not active');
            }

            $allowedTypes = [
                UserType::User,
                UserType::Admin,
                UserType::IT,
                UserType::Tester,
                UserType::Employee,
            ];

            if (! in_array($user->type, $allowedTypes, true)) {
                return null;
                // return redirect()->route('admin.login')->with('error', 'You are not allowed to login');
            }

            // تسجيل الدخول
            Auth::login($user);
            session()->regenerate();
            // return redirect()->intended(route('admin.dashboard'));

            return $user;

        } catch (\Exception $e) {
            report($e);
            return null;
            // return redirect()->route('admin.login')->with('error', 'فشل تسجيل الدخول باستخدام Google');
        }
    }
}
