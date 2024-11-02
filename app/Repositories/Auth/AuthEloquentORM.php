<?php

namespace App\Repositories\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDOException;

class AuthEloquentORM implements AuthRepositoryInterface
{
    public function __construct(protected User $model)
    {}

    public function register(RegisterDTO $registerDTO): bool
    {
        try {
            $attributes = (array) $registerDTO;

            $user = $this->model->create($attributes);

            Auth::login($user);
            return true;
        } catch (PDOException $e) {
            return false;
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
            ];

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Login failed, please try again later.',
            ];
        }
    }

}
