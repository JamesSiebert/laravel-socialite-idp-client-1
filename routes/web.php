<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Socialite
Route::get('login/passport', [LoginController::class, 'redirectToExternalAuthServer']);     // Login button pressed - Redirect to auth server
Route::get('passport/callback', [LoginController::class, 'handleExternalAuthCallback']);    // Response from Auth Server
