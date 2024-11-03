<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{RegisterController, AuthController, EmailVerificationController, ResetPasswordController};


Route::middleware('guest')->group(function () {
    //-------------------------- Register -------------------------//
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    //-------------------------- Login ----------------------------//
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    //-------------------------- Reset password ----------------------------//
    Route::get('/forgot-password', [ResetPasswordController::class, 'requestPassword'])->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'sendEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetHandler'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    //-------------------------- Logout ----------------------------//
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    //-------------------------- E-mail verification ----------------------------//
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}',
        [EmailVerificationController::class, 'handler'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('/email/verification-notification',
    [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
