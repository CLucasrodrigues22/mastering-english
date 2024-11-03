<?php

namespace App\Services;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\DTO\Auth\ForgotPasswordDTO;
use App\DTO\Auth\ResetPasswordDTO;
use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthService
{
    public function __construct(protected AuthRepositoryInterface $authRepository)
    {}

    public function register(RegisterDTO $registerDTO): array
    {
        $user = $this->authRepository->register($registerDTO);
        // send verification e-mail
        event(new Registered($user['user']));

        return [
            'status' => true,
            'message' => 'Registered successfully',
        ];
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
            return $user;
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

    public function sendEmailForgotPassword(ForgotPasswordDTO $resetPasswordDTO): array
    {
        $credentials = ['email' => $resetPasswordDTO->email];
        $status = Password::sendResetLink($credentials);

        return $status === Password::RESET_LINK_SENT
            ? [
                'status' => true,
                'message' => __($status)
            ]
            : [
                'status' => false,
                'message' => __($status)
            ];
    }

    public function resetPassword(ResetPasswordDTO $resetPasswordDTO): array
    {
        return $resetUserPassword = $this->authRepository->resetPassword($resetPasswordDTO);
    }
}
