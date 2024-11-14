<?php

namespace App\Http\Controllers;

use Inertia\{Inertia, Response as InertiaResponse};
use Illuminate\Http\{RedirectResponse, Request};


class DashboardController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $listings =
            $request->user()->role !== 'suspended' ?
            $request->user()->listings()->latest()->paginate(10) :
            null;

        return Inertia::render('Dashboard', [
            'listings' => $listings,
            'status' => session('status'),
        ]);
    }
}
