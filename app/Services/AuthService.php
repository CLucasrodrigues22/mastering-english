<?php

namespace App\Services;

use App\DTO\Auth\RegisterDTO;
use App\Repositories\Auth\AuthRepositoryInterface;

class AuthService
{
    public function __construct(protected AuthRepositoryInterface $authRepository)
    {}

    public function register(RegisterDTO $registerDTO)
    {
        $user = $this->authRepository->register($registerDTO);
        // send verification e-mail
        return $user;
    }
}
