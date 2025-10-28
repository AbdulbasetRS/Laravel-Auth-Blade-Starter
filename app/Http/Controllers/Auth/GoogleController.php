<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuthProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Enums\UserStatus;
use App\Enums\UserType;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
        // ->scopes(['https://www.googleapis.com/auth/drive.file', 'email', 'profile'])
        ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // return [$googleUser];
            // 🔍 نبحث عن provider سابق
            $provider = AuthProvider::where('provider_name', 'google')
                ->where('provider_user_id', $googleUser->getId())
                ->first();

            if ($provider) {
                $user = $provider->user;
            } else {
                // 🔍 نبحث عن مستخدم بنفس الإيميل
                $user = User::where('email', $googleUser->getEmail())->first();
                if (!$user) {
                    // 🆕 نعمل يوزر جديد
                    $user = User::create([
                        'username' => Str::slug($googleUser->getName()) . '-' . Str::random(4),
                        'slug' => Str::slug($googleUser->getName()) . '-' . Str::random(6),
                        'email' => $googleUser->getEmail(),
                        'password' => bcrypt(Str::random(12)),
                        'status' => UserStatus::Active,
                        'type' => UserType::User, // عدلها حسب الحاجة
                        'can_login' => true,
                    ]);
                }

                // 🧩 نعمل سجل فى جدول auth_providers
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
            if (!$user->can_login) {
                // return redirect('/ar/admin/login')->withErrors(['login' => 'You are not allowed to login']);
                return redirect()->route('admin.login')->with('error', 'You are not allowed to login');
            }

            if ($user->status !== UserStatus::Active) {
                // return redirect('/ar/admin/login')->withErrors(['login' => 'Your account is not active']);
                return redirect()->route('admin.login')->with('error', 'Your account is not active');
            }

            $allowedTypes = [
                UserType::User,
                UserType::Admin,
                UserType::IT,
                UserType::Tester,
                UserType::Employee,
            ];

            if (!in_array($user->type, $allowedTypes, true)) {
                // return redirect('/ar/admin/login')->withErrors(['login' => 'You are not allowed to login']);
                return redirect()->route('admin.login')->with('error', 'You are not allowed to login');
            }

            // 🔓 تسجيل الدخول
            Auth::login($user);
            session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));

        } catch (\Exception $e) {
            report($e);
            return redirect()->route('admin.login')->with('error', 'فشل تسجيل الدخول باستخدام Google');
        }
    }
}
