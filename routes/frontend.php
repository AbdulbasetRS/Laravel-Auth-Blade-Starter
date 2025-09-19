<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use App\Http\Controllers\Frontend\VerificationController as FrontendVerificationController;

Route::controller(FrontendAuthController::class)
    ->as('frontend.')
    ->group(function () {
        Route::get('/', 'home')->name('home');

        // Authentication
        Route::get('/login', 'showLoginForm')->name('login'); // frontend.login
        Route::post('/login', 'login')->name('login.submit'); // frontend.login.submit
        Route::get('/register', 'showRegisterForm')->name('register'); // frontend.register
        Route::post('/register', 'register')->name('register.submit'); // frontend.register.submit
        Route::post('/logout', 'logout')->name('logout'); // frontend.logout

        // Password Reset
        Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request'); // frontend.password.request
        Route::post('/forgot-password', 'sendResetLink')->name('password.email'); // frontend.password.email
        Route::get('/reset-password/{token}', 'showResetPasswordForm')->name('password.reset'); // frontend.password.reset
        Route::post('/reset-password', 'resetPassword')->name('password.update'); // frontend.password.update
    });

Route::controller(FrontendVerificationController::class)
    ->prefix('email')
    ->as('frontend.verification.')
    ->group(function () {
        Route::get('/verify', 'notice')->name('notice'); // frontend.verification.notice
        Route::get('/verify/{id}/{hash}', 'verify')->name('verify'); // frontend.verification.verify
        Route::post('/verification-notification', 'send')->name('send'); // frontend.verification.send
    });
