<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminController, DashboardController, ProfileController, ListingController};
use App\Http\Middleware\Admin;

// privates routes
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

// Listings routes
Route::get('/', [ListingController::class, 'index'])->name('home');
Route::resource('listing', ListingController::class)->except('index');

// Admin Routes
Route::middleware(['auth', 'verified', Admin::class])
    ->controller(AdminController::class)
    ->group(function () {
    Route::get('/admin', 'index')->name('admin.index');
    Route::get('/users/{user}', 'showUser')->name('user.show');
    Route::put('/admin/{user}/role', 'roleUpdate')->name('admin.role');
    Route::put('/listing/{listing}/approve', 'approve')->name('admin.approve');
});

// auth routes
require __DIR__. '/auth.php';
