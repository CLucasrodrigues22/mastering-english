<?php

namespace App\Services;

use App\DTO\Profile\ProfileUpdateInfoDTO;
use App\Repositories\Profile\ProfileRepositoryInterface;

class ProfileService
{
    public function __construct(protected ProfileRepositoryInterface $profileRepository)
    {}

    public function updateInfo(ProfileUpdateInfoDTO $dto): array
    {
        return $this->profileRepository->updateInfo($dto);
    }
}
