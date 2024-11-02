<?php

namespace App\Http\Controllers\Auth;

use App\DTO\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Services\AuthService;
use Inertia\{Inertia, Response as InertiaResponse};
use Illuminate\Http\{RedirectResponse, Request};

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {}

    public function index(): InertiaResponse
    {
        return Inertia::render('Auth/Login', [
            'message' => session('message'),
        ]);
    }

    public function login(AuthRequest $request): RedirectResponse
    {
        sleep(2);
        $user = $this->authService->login(
            LoginDTO::makeFromRequest($request),
        );
        if($user['status'] === false)
        {
            return redirect()->back()->withErrors([$user['message']]);
        }
        return redirect()->route('home')->with(['message' => 'You are logged in']);
    }

    public function logout(Request $request): RedirectResponse
    {
        sleep(2);
        $user = $this->authService->logout($request);
        if($user['status'] === false) {
            return redirect()->back()->withErrors([$user['message']]);
        }
        return redirect()->route('home')->with(['message' => 'You are logged out']);
    }
}
