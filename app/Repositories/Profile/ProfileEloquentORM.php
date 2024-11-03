<?php

namespace App\Repositories\Profile;

use App\DTO\Profile\ProfileUpdateInfoDTO;
use App\DTO\Profile\ProfileUpdatePasswordDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileEloquentORM implements ProfileRepositoryInterface
{
    public function __construct(protected User $model)
    {}

    public function updateInfo(ProfileUpdateInfoDTO $dto): array
    {
        try {
            $profile = $this->model->find($dto->id);
            if($profile) {
                $data = (array) $dto;
                $profile->fill($data);
                if($profile->isDirty('email'))
                {
                    $profile->email_verified_at = null;
                }
                $profile->save();
                return [
                    'status' => true,
                    'message' => 'Profile updated successfully.',
                ];
            }
            return [
                'status' => false,
                'message' => 'Profile not found, verify if email is valid or try again later.',
            ];
        } catch (\PDOException $e)
        {
            return [
              'status' => false,
              'message' => 'Something went wrong! Please try again later.',
            ];
        }
    }

    public function updatePassword(ProfileUpdatePasswordDTO $dto): array
    {
        try {
            $profile = $this->model->find($dto->id);
            if(!$profile) {
                return [
                    'status' => false,
                    'message' => 'Profile not found.',
                ];
            }
            $profile->update([
                'password' => Hash::make($dto->password),
            ]);
            return [
                'status' => true,
                'message' => 'Password updated successfully.',
            ];
        } catch (\PDOException $e)
        {
            return [
                'status' => false,
                'message' => 'Something went wrong! Please try again later.',
            ];
        }
    }
}
