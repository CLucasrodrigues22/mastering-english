<?php

namespace App\Services;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct(protected AuthRepositoryInterface $authRepository)
    {}

    public function register(RegisterDTO $registerDTO): bool
    {
        $user = $this->authRepository->register($registerDTO);
        // send verification e-mail
        return $user;
    }

    public function login(LoginDTO $loginDTO): array
    {
        $user = $this->authRepository->login($loginDTO);
        if ($user['status'] === true &&
            Auth::attempt(
                [
                    'email' => $loginDTO->email,
                    'password' => $loginDTO->password
                ],
                $loginDTO->remember)
            )
        {
            return [
                'status' => true,
                'message' => 'Login successful.',
            ];
        }
        return $user;
    }

    public function logout(Request $request): array
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return [
                'status' => true,
            ];
        } catch (\Throwable $th)
        {
            return [
                'status' => false,
            ];
        }
    }
}
