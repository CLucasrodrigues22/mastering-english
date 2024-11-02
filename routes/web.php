<?php

use Illuminate\Support\Facades\Route;

require __DIR__. '/auth.php';

Route::inertia('/', 'Home')->middleware('verified')->name('home');

