<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\TwoFactorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\Authenticate as AppAuthenticate;
use App\Http\Middleware\EnsureEmailIsVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AdminAuthController::class)
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        Route::get('auth/google/redirect', [SocialController::class, 'googleRedirect'])->name('auth.google.redirect');
        Route::get('auth/google/callback', [SocialController::class, 'googleCallback'])->name('auth.google.callback');
        Route::get('auth/gitHub/redirect', [SocialController::class, 'gitHubRedirect'])->name('auth.gitHub.redirect');
        Route::get('auth/gitHub/callback', [SocialController::class, 'gitHubCallback'])->name('auth.gitHub.callback');

        // Authentication
        Route::get('/login', 'showLoginForm')->name('login'); // admin.login
        Route::post('/login', 'login')->name('login.submit'); // admin.login.submit
        Route::get('/register', 'showRegisterForm')->name('register'); // admin.register
        Route::post('/register', 'register')->name('register.submit'); // admin.register.submit
        Route::post('/logout', 'logout')->name('logout')->middleware([AppAuthenticate::class]); // admin.logout
        Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware([AppAuthenticate::class, EnsureEmailIsVerified::class]); // admin.dashboard

        // Password Reset
        Route::get('/forgot-password', 'showForgotPasswordForm')->name('forgot-password'); // admin.forgot-password
        Route::post('/forgot-password', 'sendResetLink')->name('forgot-password.submit'); // admin.forgot-password.submit
        Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('reset-password'); // admin.reset-password
        Route::post('/reset-password', 'resetPassword')->name('reset-password.submit'); // admin.reset-password.submit

        // Email Verification
        Route::get('/verify', 'verificationNotice')->name('verification-notice'); // admin.verification-notice
        Route::get('/verify/{id}/{hash}', 'verificationVerify')->name('verification-verify'); // admin.verification-verify
        Route::post('/verification-notification', 'sendVerificationNotification')->name('verification-notification.submit'); // admin.verification-notification.submit
    });

// Two-Factor Authentication (Guest - Login Verification)
Route::controller(TwoFactorController::class)
    ->prefix('admin/two-factor')
    ->as('admin.two-factor.')
    ->group(function () {
        Route::get('/verify', 'showVerify')->name('verify'); // admin.two-factor.verify
        Route::post('/verify', 'verifyLogin')->name('verify.login'); // admin.two-factor.verify.login
    });

Route::prefix('admin')
    ->as('admin.')
    ->middleware([AppAuthenticate::class, EnsureEmailIsVerified::class])
    ->group(function () {

        /*
            |--------------------------------------------------------------------------
            | Resource Routes for Admin Users Management
            |--------------------------------------------------------------------------
            | GET       /admin/users              -> admin.users.index
            | GET       /admin/users/create       -> admin.users.create
            | POST      /admin/users              -> admin.users.store
            | GET       /admin/users/{slug}       -> admin.users.show
            | GET       /admin/users/{slug}/edit  -> admin.users.edit
            | PUT/PATCH /admin/users/{slug}       -> admin.users.update
            | DELETE    /admin/users/{slug}       -> admin.users.destroy
        */
        Route::resource('users', UserController::class)
            ->parameters(['users' => 'user:slug'])
            ->names('users');

        // Two-Factor Authentication Settings
        Route::controller(TwoFactorController::class)
            ->prefix('two-factor')
            ->as('two-factor.')
            ->group(function () {
                Route::post('/confirm', 'verify')->name('confirm'); // admin.two-factor.confirm (for enabling)
            });

        Route::prefix('user-settings')
            ->as('user-settings.')
            ->group(function () {
                Route::get('two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable'); // admin.user-settings.two-factor.enable
                Route::post('two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable'); // admin.user-settings.two-factor.disable
                Route::get('two-factor/', [TwoFactorController::class, 'index'])->name('two-factor.index'); // admin.user-settings.two-factor.index
                Route::post('two-factor/regenerate', [TwoFactorController::class, 'regenerate'])->name('two-factor.regenerate');

            });

        Route::prefix('app-settings')
            ->as('app-settings.')
            ->group(function () {
                //
            });

        // Notifications API (paginated) - used by the notifications component
        Route::resource('notifications', NotificationController::class)
            ->names('notifications');

    });

// Admin fallback (must be last): any unmatched /admin/* goes to admin 404
Route::prefix('admin')->group(function () {
    Route::fallback(function () {
        return response()->view('errors.admin-404', [], 404);
    });
});
