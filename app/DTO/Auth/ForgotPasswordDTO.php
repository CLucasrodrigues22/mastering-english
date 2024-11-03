<?php

namespace App\DTO\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;

class ForgotPasswordDTO
{
    public function __construct
    (
        public string $email,
    )
    {}

    public static function makeFromRequest(ForgotPasswordRequest $request): self
    {
        return new self(
          $request->email
        );
    }
}
