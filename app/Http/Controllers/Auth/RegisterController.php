<?php

namespace App\Http\Controllers\Auth;

use App\DTO\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Inertia\{Inertia, Response as InertiaResponse};
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function __construct(protected AuthService $authService)
    {}

    /**
     * Display form register page.
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        sleep(2);
        $user = $this->authService->register(
            RegisterDTO::makeFromRequest($request),
        );
        if ($user === false) {
            return back()->withErrors(['errors' => 'Registration failed. Try again later.']);
        }
        return redirect()->route('dashboard');
    }
}
