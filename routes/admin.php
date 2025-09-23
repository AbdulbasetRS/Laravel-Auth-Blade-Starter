<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\Authenticate as AppAuthenticate;
use App\Http\Middleware\EnsureEmailIsVerified;

Route::controller(AdminAuthController::class)
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
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


// Admin Users Management
Route::controller(UserController::class)
    ->prefix('admin/users')
    ->as('admin.users.')
    ->middleware([AppAuthenticate::class, EnsureEmailIsVerified::class])
    ->group(function () {
        Route::get('/', 'index')->name('index'); // admin.users.index
        Route::get('/create', 'create')->name('create'); // admin.users.create
        Route::post('/', 'store')->name('store'); // admin.users.store
        Route::get('/{id}', 'show')->name('show'); // admin.users.show
        Route::get('/{id}/edit', 'edit')->name('edit'); // admin.users.edit
        Route::put('/{id}', 'update')->name('update'); // admin.users.update
        Route::delete('/{id}', 'destroy')->name('destroy'); // admin.users.destroy
    });
