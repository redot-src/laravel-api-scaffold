<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your dashboard. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', [\App\Http\Controllers\Dashboard\HomeController::class, 'index'])->name('index');

Route::middleware('auth:admins')->group(function () {
    // ...
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register auth routes for your application. These
| routes are helpful when building the login and registration screens
| for your application.
|
*/

Route::prefix('auth')->group(function () {
    Route::middleware('guest:admins')->group(function () {
        Route::post('/login', [\App\Http\Controllers\Dashboard\Auth\AuthenticatedSessionController::class, 'store'])->name('login');
        Route::post('/forgot-password', [\App\Http\Controllers\Dashboard\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::post('/reset-password', [\App\Http\Controllers\Dashboard\Auth\NewPasswordController::class, 'store'])->name('password.store');
    });

    Route::middleware('auth:admins')->group(function () {
        Route::get('/me', [\App\Http\Controllers\Dashboard\Auth\AuthenticatedSessionController::class, 'show'])->name('me');
        Route::post('/register', [\App\Http\Controllers\Dashboard\Auth\RegisteredUserController::class, 'store'])->name('register');
        Route::delete('/logout', [\App\Http\Controllers\Dashboard\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
