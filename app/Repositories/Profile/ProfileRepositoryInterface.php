<?php

namespace App\Repositories\Profile;

use App\DTO\Profile\ProfileUpdateInfoDTO;

interface ProfileRepositoryInterface
{
    public function updateInfo(ProfileUpdateInfoDTO $dto): array;
}
