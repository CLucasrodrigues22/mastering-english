<?php

namespace App\DTO\Profile;

use App\Http\Requests\ProfileRequest;

class ProfileDeleteAccountDTO
{
    public function __construct
    (
        public int    $id,
        public string $password,
    )
    {}

    public static function makeFromRequestDeleteAccount(ProfileRequest $profileRequest): self
    {
        return new self
        (
            $profileRequest->id,
            $profileRequest->password
        );
    }
}
