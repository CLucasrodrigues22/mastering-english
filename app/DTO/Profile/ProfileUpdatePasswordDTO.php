<?php

namespace App\DTO\Profile;

use App\Http\Requests\ProfileRequest;

class ProfileUpdatePasswordDTO
{
    public function __construct
    (
        public int $id,
        public string $current_password,
        public string $password
    )
    {}

    public static function makeFromRequestUpdatePassword(ProfileRequest $request): self
    {
        return new self
        (
            $request->id,
            $request->current_password,
            $request->password
        );
    }
}
