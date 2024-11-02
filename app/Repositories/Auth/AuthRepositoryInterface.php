<?php

namespace App\Repositories\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;

interface AuthRepositoryInterface
{
    public function register(RegisterDTO $registerDTO): array;
    public function login(LoginDTO $loginDTO): array;
}
