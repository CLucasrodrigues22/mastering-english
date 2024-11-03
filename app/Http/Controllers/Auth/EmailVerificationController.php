<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\{Request, RedirectResponse};
use Inertia\{Inertia, Response as InertiaResponse};

class EmailVerificationController extends Controller
{
    public function notice(Request $request): InertiaResponse
    {
        return Inertia::render('Auth/VerifyEmail', [
            'user' => $request->user(),
            'status' => session('status')
        ]);
    }

    public function handler(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();
        return redirect()->route('home');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Verification link sent!');
    }
}
