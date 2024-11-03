<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    DashboardController,
    ProfileController
};

require __DIR__. '/auth.php';

Route::inertia('/', 'Home')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');
    Route::get('/profile',[ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'updateInfo'])
        ->name('profile.update.info');
});

