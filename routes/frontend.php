<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\VerificationController as FrontendVerificationController;

Route::controller(FrontendAuthController::class)
    ->as('frontend.')
    ->group(function () {
        Route::get('/', 'home')->name('home');

        // Authentication
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login.submit');
        Route::get('/register', 'showRegisterForm')->name('register');
        Route::post('/register', 'register')->name('register.submit');
        Route::post('/logout', 'logout')->name('logout');

        // Password Reset
        Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request');
        Route::post('/forgot-password', 'sendResetLink')->name('password.email');
        Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
        Route::post('/reset-password', 'resetPassword')->name('password.update');
    });

Route::controller(FrontendVerificationController::class)
    ->prefix('email')
    ->as('frontend.verification.')
    ->group(function () {
        Route::get('/verify', 'notice')->name('notice');
        Route::get('/verify/{id}/{hash}', 'verify')->name('verify');
        Route::post('/verification-notification', 'send')->name('send');
    });
