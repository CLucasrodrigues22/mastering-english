<?php

namespace App\Services;

use App\DTO\Profile\ProfileDeleteAccountDTO;
use App\DTO\Profile\ProfileUpdateInfoDTO;
use App\DTO\Profile\ProfileUpdatePasswordDTO;
use App\Repositories\Profile\ProfileRepositoryInterface;

class ProfileService
{
    public function __construct(protected ProfileRepositoryInterface $profileRepository)
    {}

    public function updateInfo(ProfileUpdateInfoDTO $dto): array
    {
        return $this->profileRepository->updateInfo($dto);
    }

    public function updatePassword(ProfileUpdatePasswordDTO $dto): array
    {
        return $this->profileRepository->updatePassword($dto);
    }

    public function deleteAccount(ProfileDeleteAccountDTO $dto): array
    {
        return $this->profileRepository->deleteAccount($dto);
    }
}
