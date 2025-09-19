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
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login.submit');
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/dashboard', 'dashboard')->name('dashboard');

        // Password Reset
        Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLink')->name('password.email');
        Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
        Route::post('/reset-password', 'resetPassword')->name('password.update');
    });

Route::controller(AdminVerificationController::class)
    ->prefix('admin/email')
    ->as('admin.verification.')
    ->group(function () {
        Route::get('/verify', 'notice')->name('notice');
        Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
        Route::post('/verification-notification', 'send')->name('send');
    });

// Admin Users Management
Route::controller(UserController::class)
    ->prefix('admin/users')
    ->as('admin.users.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
