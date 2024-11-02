<?php

namespace App\Repositories\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;

interface AuthRepositoryInterface
{
    public function register(RegisterDTO $registerDTO): bool;
    public function login(LoginDTO $loginDTO): array;
}
