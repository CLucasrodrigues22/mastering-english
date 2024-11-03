<?php

namespace App\Http\Controllers;

use App\DTO\Profile\ProfileUpdateInfoDTO;
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
            'message' => session('message'),
        ]);
    }

    public function updateInfo(ProfileRequest $request): RedirectResponse
    {
        $profile = $this->profileService->updateInfo(
            ProfileUpdateInfoDTO::makeFromRequest($request),
        );

        if($profile) {
            return back()->with(['message' => $profile['message']]);
        }

        return back()->withErrors(['message' => 'Failed to update profile info.']);
    }
}
