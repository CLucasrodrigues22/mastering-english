<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Services\AuthService;
use Inertia\{Inertia, Response as InertiaResponse};
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {}

    public function index(): InertiaResponse
    {
        return Inertia::render('Auth/Login');
    }

    public function login(AuthRequest $request): RedirectResponse
    {

    }
}
