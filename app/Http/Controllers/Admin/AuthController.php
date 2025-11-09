<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Exceptions\EmailNotVerifiedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\Auth\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $loginService = new LoginService;
        $identifier = $request->identifier;
        $password = $request->password;
        $remember = (bool) $request->remember_me;

        try {

            $user = $loginService->attemptCredentialsLogin($identifier, $password, $request, $remember);

            // Check if 2FA verification is required
            if (! $user && $request->session()->has('2fa:user:id')) {
                return redirect()->route('admin.two-factor.verify');
            }

            if (! $user) {
                return back()->withErrors(['login' => 'auth invalid credentials']);
            }

            return redirect()->intended(route('admin.dashboard'));

        } catch (EmailNotVerifiedException $e) {
            return redirect()
                ->route('admin.verification-notice')
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {

            return back()->withErrors(['login' => $e->getMessage()]);
        }
    }

    // public function login(LoginRequest $request)
    // {
    //     $login = $request->identifier;
    //     $password = $request->password;

    //     $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email'
    //         : (is_numeric($login) ? 'mobile_number' : 'username');

    //     $user = User::where($fieldType, $login)->first();

    //     if (!$user) {
    //         return back()->withErrors(['login' => 'Invalid login credentials']);
    //     }

    //     if (!$user->can_login) {
    //         return back()->withErrors(['login' => 'You are not allowed to login']);
    //     }

    //     // Ensure the user status is Active (enum-safe comparison)
    //     if ($user->status !== UserStatus::Active) {
    //         return back()->withErrors(['login' => 'Your account is not active']);
    //     }

    //     // Allow only specific user types (strict enum comparison)
    //     $allowedTypes = [
    //         UserType::User,
    //         UserType::Admin,
    //         UserType::IT,
    //         UserType::Tester,
    //         UserType::Employee,
    //     ];
    //     if (!in_array($user->type, $allowedTypes, true)) {
    //         return back()->withErrors(['login' => 'You are not allowed to login']);
    //     }

    //     // Validate credentials without logging in, to check verification state first
    //     $credentialsValid = Auth::validate([$fieldType => $login, 'password' => $password]);
    //     if ($credentialsValid && is_null($user->email_verified_at)) {
    //         // Store for resend usage and redirect to verification notice
    //         $request->session()->put('verification_user_id', $user->id);
    //         return redirect()->route('admin.verification-notice')->with('error', 'حسابك غير مفعل. رجاءً تحقق من بريدك الإلكتروني لتفعيل الحساب.');
    //     }

    //     if (Auth::attempt([$fieldType => $login, 'password' => $password], $request->remember_me)) {
    //         // Regenerate session to prevent fixation
    //         $request->session()->regenerate();

    //         // Redirect to intended URL if present, otherwise fallback to dashboard
    //         return redirect()->intended(route('admin.dashboard'));
    //     }

    //     return back()->withErrors(['login' => 'Invalid login credentials']);
    // }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('admin.login');
    }

    // Register
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        // Validate incoming registration data
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:50', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'mobile_number' => ['required', 'string', 'max:50', 'unique:users,mobile_number'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
        ], [
            'username.required' => 'اسم المستخدم مطلوب',
            'username.unique' => 'اسم المستخدم مسجل مسبقًا',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقًا',
            'mobile_number.required' => 'رقم الجوال مطلوب',
            'mobile_number.unique' => 'رقم الجوال مسجل مسبقًا',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'first_name.required' => 'الاسم الأول مطلوب',
            'last_name.required' => 'اسم العائلة مطلوب',
        ]);

        try {
            DB::beginTransaction();

            // Generate a unique slug based on username
            $baseSlug = Str::slug($validated['username']);
            $slug = $baseSlug;
            $counter = 1;
            while (User::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$counter++;
            }

            // Create user
            $user = User::create([
                'username' => $validated['username'],
                'slug' => $slug,
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'],
                'password' => Hash::make($validated['password']),
                'status' => UserStatus::Pending,
                'type' => UserType::User,
                'can_login' => true,
            ]);

            // Create profile
            $user->profile()->create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
            ]);

            DB::commit();

            // Store for verification flow and redirect to notice (auto-sends email with throttle)
            $request->session()->put('verification_user_id', $user->id);

            return redirect()->route('admin.verification-notice')
                ->with('status', 'تم إنشاء الحساب بنجاح. قم بالتحقق من بريدك الإلكتروني لتفعيل الحساب.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Registration failed', ['error' => $e->getMessage()]);

            return back()->with('error', 'تعذر إنشاء الحساب حاليًا. الرجاء المحاولة لاحقًا.')
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    // Password Reset
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        // 1) Validate email input
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.exists' => 'لا يوجد مستخدم بهذا البريد',
        ]);

        $email = $data['email'];

        // 2) Generate a secure random token and store hashed token
        $plainToken = Str::random(64);
        $hashedToken = Hash::make($plainToken);

        // Ensure table password_reset_tokens exists. Laravel 10 default: email, token, created_at
        // Remove previous tokens for this email to avoid clutter
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $hashedToken,
            'created_at' => now(),
        ]);

        // 3) Send email with reset link (include plain token and email)
        $resetUrl = route('admin.reset-password', ['token' => $plainToken]).'?email='.urlencode($email);

        Mail::send('emails.admin.reset-password', ['resetUrl' => $resetUrl, 'email' => $email], function ($message) use ($email) {
            $message->to($email)
                ->subject(__('Reset Password Notification'));
        });

        return back()->with('status', 'تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني');
    }

    // Reset Password
    public function showResetPasswordForm(string $token)
    {
        // The email may arrive via query string
        $email = request()->query('email');

        return view('admin.auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        // 1) Validate input
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
            'email.exists' => 'لا يوجد مستخدم بهذا البريد',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
        ]);

        $email = $validated['email'];
        $plainToken = $validated['token'];

        // 2) Fetch token record and verify
        $record = DB::table('password_reset_tokens')->where('email', $email)->first();
        if (! $record) {
            return back()->withErrors(['email' => 'الرمز غير صالح أو منتهي'])->withInput($request->except('password', 'password_confirmation'));
        }

        // Token expiry (e.g., 60 minutes)
        $expiresAt = \Carbon\Carbon::parse($record->created_at)->addMinutes(60);
        if (now()->greaterThan($expiresAt)) {
            // Cleanup expired token
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return back()->withErrors(['email' => 'انتهت صلاحية رابط إعادة التعيين، الرجاء المحاولة مجددًا'])->withInput($request->except('password', 'password_confirmation'));
        }

        if (! Hash::check($plainToken, $record->token)) {
            return back()->withErrors(['email' => 'الرمز غير صالح'])->withInput($request->except('password', 'password_confirmation'));
        }

        // 3) Update user password
        $user = User::where('email', $email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'المستخدم غير موجود'])->withInput($request->except('password', 'password_confirmation'));
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        // 4) Delete token
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // 5) Redirect to login with status
        return redirect()->route('admin.login')->with('status', 'تم تحديث كلمة المرور بنجاح، يمكنك تسجيل الدخول الآن');
    }

    // Email Verification
    public function verificationNotice(Request $request)
    {
        // Try to get the user needing verification from session or current auth
        $user = null;
        if ($request->session()->has('verification_user_id')) {
            $user = User::find($request->session()->get('verification_user_id'));
        }
        if (! $user && Auth::check()) {
            $user = Auth::user();
        }

        // Auto-send verification email with cooldown when landing on this page
        if ($user && is_null($user->email_verified_at)) {
            $key = 'verify_resend_user_'.$user->id;
            if (! Cache::has($key)) {
                Cache::put($key, true, now()->addSeconds(60));

                $url = URL::temporarySignedRoute(
                    'admin.verification-verify',
                    now()->addMinutes(60),
                    ['id' => $user->id, 'hash' => sha1($user->email)]
                );

                try {
                    Mail::send('emails.admin.verify-email', ['verifyUrl' => $url, 'user' => $user], function ($message) use ($user) {
                        $message->to($user->email)
                            ->subject(__('Email Verification'));
                    });
                    session()->flash('status', 'تم إرسال رسالة التحقق إلى بريدك الإلكتروني');
                } catch (\Throwable $e) {
                    Log::error('Failed to send verification email', ['user_id' => $user->id, 'error' => $e->getMessage()]);
                    session()->flash('error', 'تعذر إرسال رسالة التحقق حاليًا. الرجاء المحاولة لاحقًا.');
                }
            } else {
                session()->flash('status', 'تم إرسال رسالة التحقق مؤخرًا. يمكنك طلب إعادة الإرسال بعد دقيقة.');
            }
        }

        return view('admin.auth.verification-notice', compact('user'));
    }

    public function verificationVerify(Request $request, $id, $hash)
    {
        // Validate signature and expiry
        if (! URL::hasValidSignature($request)) {
            return redirect()->route('admin.verification-notice')->with('error', 'رابط التحقق غير صالح أو منتهي');
        }

        $user = User::find($id);
        if (! $user) {
            return redirect()->route('admin.verification-notice')->with('error', 'المستخدم غير موجود');
        }

        // Confirm hash matches email
        if (! hash_equals((string) $hash, sha1($user->email))) {
            return redirect()->route('admin.verification-notice')->with('error', 'رابط التحقق غير صالح');
        }

        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        // Optionally clear the session flag
        $request->session()->forget('verification_user_id');

        return view('admin.auth.verification-verify', ['user' => $user]);
    }

    public function sendVerificationNotification(Request $request)
    {
        // Determine target user
        $user = null;
        if ($request->session()->has('verification_user_id')) {
            $user = User::find($request->session()->get('verification_user_id'));
        }
        if (! $user && Auth::check()) {
            $user = Auth::user();
        }
        if (! $user) {
            return back()->with('error', 'لا يوجد مستخدم لإعادة إرسال التحقق له');
        }

        if (! is_null($user->email_verified_at)) {
            return redirect()->route('admin.dashboard');
        }

        // Throttle: allow once per 60 seconds per user
        $key = 'verify_resend_user_'.$user->id;
        if (Cache::has($key)) {
            return back()->with('status', 'تم إرسال رسالة التحقق مؤخرًا. يمكنك طلب إعادة الإرسال بعد دقيقة.');
        }

        Cache::put($key, true, now()->addSeconds(60));

        // Build signed URL valid for 60 minutes
        $url = URL::temporarySignedRoute(
            'admin.verification-verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        // Send email
        try {
            Mail::send('emails.admin.verify-email', ['verifyUrl' => $url, 'user' => $user], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject(__('Email Verification'));
            });

            return back()->with('status', 'تم إرسال رسالة التحقق إلى بريدك الإلكتروني');
        } catch (\Throwable $e) {
            Log::error('Failed to send verification email (manual resend)', ['user_id' => $user->id, 'error' => $e->getMessage()]);

            return back()->with('error', 'تعذر إرسال رسالة التحقق حاليًا. الرجاء المحاولة لاحقًا.');
        }
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
