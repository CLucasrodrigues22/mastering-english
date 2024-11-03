<?php

namespace App\Http\Controllers;

use Inertia\{Inertia, Response as InertiaResponse};
use Illuminate\Http\{RedirectResponse, Request};


class DashboardController extends Controller
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Dashboard');
    }
}
