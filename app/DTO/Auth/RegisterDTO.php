<?php

namespace App\DTO\Auth;

use App\Http\Requests\StoreRegisterRequest;

class RegisterDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ){}

    public static function makeFromRequest(StoreRegisterRequest $request): self
    {
        return new self(
            $request->name,
            $request->email,
            $request->password
        );
    }
}
