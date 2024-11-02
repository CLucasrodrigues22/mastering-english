<?php

namespace App\DTO\Auth;

use App\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordDTO
{
    public function __construct(
        public string $token,
        public string $email,
        public string $password,
    )
    {}

    public static function makeFromRequest(ResetPasswordRequest $request): self
    {
        return new self(
            $request->token,
            $request->email,
            $request->password,
        );
    }
}
