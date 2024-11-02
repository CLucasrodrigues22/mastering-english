<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware('guest')->group(function () {
    //-------------------------- Register -------------------------//
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    //-------------------------- Login ----------------------------//

});
