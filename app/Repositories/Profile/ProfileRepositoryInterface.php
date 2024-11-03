<?php

namespace App\Repositories\Profile;

use App\DTO\Profile\ProfileDeleteAccountDTO;
use App\DTO\Profile\ProfileUpdateInfoDTO;
use App\DTO\Profile\ProfileUpdatePasswordDTO;

interface ProfileRepositoryInterface
{
    public function updateInfo(ProfileUpdateInfoDTO $dto): array;
    public function updatePassword(ProfileUpdatePasswordDTO $dto): array;
    public function deleteAccount(ProfileDeleteAccountDTO $dto): array;
}
