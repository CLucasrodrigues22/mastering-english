<?php

namespace App\Repositories\Auth;

use App\DTO\Auth\RegisterDTO;

interface AuthRepositoryInterface
{
    public function register(RegisterDTO $registerDTO);

}
