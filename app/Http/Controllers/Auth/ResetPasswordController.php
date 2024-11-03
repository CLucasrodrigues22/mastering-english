<?php

namespace App\Http\Controllers\Auth;

use App\DTO\Auth\ForgotPasswordDTO;
use App\DTO\Auth\ResetPasswordDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\{Inertia, Response as InertiaResponse};

class ResetPasswordController extends Controller
{
    public function __construct(protected AuthService $authService)
    {}
    public function requestPassword(): InertiaResponse
    {
        return Inertia::render('Auth/ForgotPassword', [
            'message' => session('message'),
        ]);
    }

    public function sendEmail(ForgotPasswordRequest $request): RedirectResponse
    {
        $forgotPwd = $this->authService->sendEmailForgotPassword(
            ForgotPasswordDTO::makeFromRequest($request),
        );

        if($forgotPwd['status'] === false)
        {
            return Redirect::back()->withErrors(['message' => $forgotPwd['message']]);
        }
        return Redirect::back()->with('message', $forgotPwd['message']);
    }

    public function resetForm(ForgotPasswordRequest $request): InertiaResponse
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    public function resetHandler(ResetPasswordRequest $request): RedirectResponse
    {
        $resetPwd = $this->authService->resetPassword(
            ResetPasswordDTO::makeFromRequest($request),
        );

        if($resetPwd['status'] === false)
        {
            return redirect()->back()->withErrors(['message' => $resetPwd['message']]);
        }
        return redirect()->route('login')->with('message', $resetPwd['message']);
    }
}
