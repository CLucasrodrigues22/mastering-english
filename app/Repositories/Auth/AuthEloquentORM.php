<?php

namespace App\Repositories\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\DTO\Auth\ResetPasswordDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PDOException;

class AuthEloquentORM implements AuthRepositoryInterface
{
    public function __construct(protected User $model)
    {}

    public function register(RegisterDTO $registerDTO): array
    {
        try {
            $attributes = (array) $registerDTO;

            $user = $this->model->create($attributes);

            Auth::login($user);
            return [
                'status' => true,
                'user' => $user,
            ];
        } catch (PDOException $e) {
            return [
                'status' => false,
                'message' => 'Sorry, something went wrong.',
            ];
        }
    }

    public function login(LoginDTO $loginDTO): array
    {
        try {
            $user = $this->model->where('email', $loginDTO->email)->first();

            if (!$user || !Hash::check($loginDTO->password, $user->password)) {
                return [
                    'status' => false,
                    'message' => 'Invalid credentials.',
                ];
            }

            Auth::login($user);
            return [
                'status' => true,
                'message' => 'Logged in successfully.',
            ];

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Login failed, please try again later.',
            ];
        }
    }

    public function resetPassword(ResetPasswordDTO $resetPasswordDTO): array
    {
        try {
            // find user
            $user = $this->model->where('email', $resetPasswordDTO->email)->first();
            if($user)
            {
                $user->forceFill([
                    'password' => Hash::make($resetPasswordDTO->password),
                ])->setRememberToken(Str::random(60));
                $user->save();
                return [
                    'status' => true,
                    'message' => 'Password reset successfully.',
                ];
            }
            return [
                'status' => false,
                'message' => 'Email does not exist.',
            ];
        } catch (PDOException $e) {
            return [
                'status' => false,
                'message' => 'Reset password failed, please try again later.',
            ];
        }
    }
}
