<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;


// prepare . v1/oauth/


Route::prefix('api/v1/sessions')->middleware('entity.is_defined')->as('api.v1.sessions.')->group(function () {
    Route::post('/new', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('spa.generate');

    Route::delete('/', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('spa.revoke');

    Route::post('bearer/new', [AuthenticatedSessionController::class, 'generateBearerToken'])->name('bearertoken.generate');
    Route::delete('bearer', [AuthenticatedSessionController::class, 'revokeBearerToken'])->middleware('auth:sanctum')->name('bearertoken.revoke');
});


// Route::post('/register', [RegisteredUserController::class, 'store'])
//     ->middleware('guest')
//     ->name('register');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');
