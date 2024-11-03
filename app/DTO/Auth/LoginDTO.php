<?php

namespace App\DTO\Auth;

use App\Http\Requests\Auth\AuthRequest;

class LoginDTO
{
    public function __construct(
        public string    $email,
        public string    $password,
        public bool|null $remember,
    )
    {}

    public static function makeFromRequest(AuthRequest $authRequest): self
    {
        return new self
        (
            $authRequest->email,
            $authRequest->password,
            $authRequest->remember
        );
    }
}
