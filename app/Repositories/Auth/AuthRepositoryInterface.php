<?php

namespace App\Repositories\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\DTO\Auth\ResetPasswordDTO;

interface AuthRepositoryInterface
{
    public function register(RegisterDTO $registerDTO): array;
    public function login(LoginDTO $loginDTO): array;
    public function resetPassword(ResetPasswordDTO $resetPasswordDTO): array;
}
