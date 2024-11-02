<?php

namespace App\Repositories\Auth;

use App\DTO\Auth\RegisterDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
}
