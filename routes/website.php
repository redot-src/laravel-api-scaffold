<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your website. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', [\App\Http\Controllers\Website\HomeController::class, 'index'])->name('index');

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
    Route::middleware('guest:users')->group(function () {
        Route::post('/register', [\App\Http\Controllers\Website\Auth\RegisteredUserController::class, 'store'])->name('register');
        Route::post('/login', [\App\Http\Controllers\Website\Auth\AuthenticatedSessionController::class, 'store'])->name('login');
        Route::post('/forgot-password', [\App\Http\Controllers\Website\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::post('/reset-password', [\App\Http\Controllers\Website\Auth\NewPasswordController::class, 'store'])->name('password.store');
    });

    Route::middleware('auth:users')->group(function () {
        Route::get('/me', [\App\Http\Controllers\Website\Auth\AuthenticatedSessionController::class, 'show'])->name('me');
        Route::get('/verify-email/{id}/{hash}', \App\Http\Controllers\Website\Auth\VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        Route::post('/email/verification-notification', [\App\Http\Controllers\Website\Auth\EmailVerificationNotificationController::class, 'store'])->middleware(['throttle:6,1'])->name('verification.send');
        Route::delete('/logout', [\App\Http\Controllers\Website\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
