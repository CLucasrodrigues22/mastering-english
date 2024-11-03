<?php

namespace App\DTO\Profile;

use App\Http\Requests\ProfileRequest;

class ProfileUpdateInfoDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ){}

    public static function makeFromRequestUpdateInfo(ProfileRequest $request): self
    {
        return new self(
            $request->id,
            $request->name,
            $request->email
        );
    }
}
