<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\WelcomeController;

// Load admin routes
require __DIR__ . '/admin.php';

Route::controller(WelcomeController::class)->as('frontend.')->group(function () {
    Route::get('/', 'home')->name('home');
});