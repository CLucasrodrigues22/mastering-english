<?php

namespace App\Http\Controllers;

use App\DTO\Profile\ProfileUpdateInfoDTO;
use App\DTO\Profile\ProfileUpdatePasswordDTO;
use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;
use Inertia\{Inertia, Response as InertiaResponse};
use Illuminate\Http\{RedirectResponse, Request};

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $profileService)
    {}

    public function edit(Request $request): InertiaResponse
    {
        return Inertia::render('Profile/Edit', [
            'user' => $request->user(),
            'status' => session('status'),
            'update_info_message' => session('update_info_message'),
            'update_pwd_message' => session('update_pwd_message'),
        ]);
    }

    public function updateInfo(ProfileRequest $request): RedirectResponse
    {
        $profile = $this->profileService->updateInfo(
            ProfileUpdateInfoDTO::makeFromRequestUpdateInfo($request),
        );

        if($profile) {
            return back()->with(['update_info_message' => $profile['message']]);
        }

        return back()->withErrors(['update_info_message' => 'Failed to update profile info.']);
    }

    public function updatePassword(ProfileRequest $request): RedirectResponse
    {
        $resetPwd = $this->profileService->updatePassword(
            ProfileUpdatePasswordDTO::makeFromRequestUpdatePassword($request),
        );
        if($resetPwd) {
            return back()->with(['update_pwd_message' => $resetPwd['message']]);
        }
        return back()->withErrors(['update_pwd_message' => 'Failed to update password.']);
    }
}
