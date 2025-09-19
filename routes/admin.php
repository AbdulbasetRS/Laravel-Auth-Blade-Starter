<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use App\Http\Controllers\Admin\UserController;

Route::controller(AdminAuthController::class)
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        // Authentication
        Route::get('/login', 'showLoginForm')->name('login'); // admin.login
        Route::post('/login', 'login')->name('login.submit'); // admin.login.submit
        Route::post('/logout', 'logout')->name('logout'); // admin.logout
        Route::get('/dashboard', 'dashboard')->name('dashboard'); // admin.dashboard

        // Password Reset
        Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request'); // admin.password.request
        Route::post('/forgot-password', 'sendResetLink')->name('password.email'); // admin.password.email
        Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset'); // admin.password.reset
        Route::post('/reset-password', 'resetPassword')->name('password.update'); // admin.password.update
    });

Route::controller(AdminVerificationController::class)
    ->prefix('admin/email')
    ->as('admin.verification.')
    ->group(function () {
        Route::get('/verify', 'notice')->name('notice'); // admin.verification.notice
        Route::get('/verify/{id}/{hash}', 'verify')->name('verify'); // admin.verification.verify
        Route::post('/verification-notification', 'send')->name('send'); // admin.verification.send
    });

// Admin Users Management
Route::controller(UserController::class)
    ->prefix('admin/users')
    ->as('admin.users.')
    ->group(function () {
        Route::get('/', 'index')->name('index'); // admin.users.index
        Route::get('/create', 'create')->name('create'); // admin.users.create
        Route::post('/', 'store')->name('store'); // admin.users.store
        Route::get('/{id}', 'show')->name('show'); // admin.users.show
        Route::get('/{id}/edit', 'edit')->name('edit'); // admin.users.edit
        Route::put('/{id}', 'update')->name('update'); // admin.users.update
        Route::delete('/{id}', 'destroy')->name('destroy'); // admin.users.destroy
    });
