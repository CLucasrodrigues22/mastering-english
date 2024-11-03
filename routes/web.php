<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    ListingController
};

Route::get('/', [ListingController::class, 'index'])->name('home');
require __DIR__. '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');
    Route::get('/profile',[ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'updateInfo'])
        ->name('profile.update.info');
    Route::put('/profile', [ProfileController::class, 'updatePassword'])
        ->name('profile.update.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::resource('listing', ListingController::class)->except('index');
