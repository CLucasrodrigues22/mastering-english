<?php

namespace App\Http\Controllers\Auth;

use App\DTO\Auth\RegisterDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Http\Requests\UpdateRegisterRequest;
use App\Services\AuthService;
use Inertia\{Inertia, Response as InertiaResponse};

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
    public function store(StoreRegisterRequest $request)
    {
        sleep(2);
        $user = $this->authService->register(
            RegisterDTO::makeFromRequest($request),
        );
        if ($user === false) {
            return back()->withErrors(['errors' => 'Registration failed. Try again later.']);
        }
        return redirect()->route('home');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegisterRequest $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
