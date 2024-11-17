<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Inertia\{Inertia, Response as InertiaResponse};
use Illuminate\Http\{RedirectResponse, Request};

class AdminController extends Controller
{
    public function index(): InertiaResponse
    {
        $users = User::with('listings')
            ->filter(request(['search', 'user_role']))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/AdminDashboard', [
            'users' => $users,
        ]);
    }

    public function showUser(User $user): InertiaResponse
    {
        $user_listings = $user
            ->listings()
            ->filter(request(['search', 'disapproved']))
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Admin/UserPage', [
            'user' => $user,
            'listings' => $user_listings,
        ]);
    }

    public function approve(Listing $listing): RedirectResponse
    {
        Gate::authorize('approve', $listing);

        $listing->update(['approved' => !$listing->approved]);

        return back()->with('success', 'Listing has been updated.');
    }

    public function roleUpdate(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('modifyRole', $user);

        $user->update(['role' => $request->role]);

        return redirect()
            ->route('admin.index')
            ->with('success', 'User role updated.');
    }
}
