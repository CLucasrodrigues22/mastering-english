<?php

namespace App\Http\Controllers;

use App\DTO\Listing\ListingDTO;
use App\Http\Middleware\NotSuspended;
use App\Http\Requests\ListingRequest;
use App\Models\Listing;
use App\Services\ListingService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\{RedirectResponse, Request};
use Inertia\{Inertia, Response as InertiaResponse};

class ListingController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(
                ['auth', 'verified', NotSuspended::class],
                except: ['index', 'show'],
            )
        ];
    }

    public function __construct(protected ListingService $listingService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): InertiaResponse
    {
        $listings = $this->listingService->getAll($request);
        return Inertia::render('Home', [
            'listings' => $listings['data'],
            'searchTerms' => $request->search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): InertiaResponse
    {
        Gate::authorize('create', Listing::class);

        return Inertia::render('Listing/Create', [
            'info_list_create' => [
                'message' => session('message'),
                'status' => session('status'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListingRequest $request): RedirectResponse
    {
        Gate::authorize('create', Listing::class);

        $listing = $this->listingService->create(
            ListingDTO::makeFromRequestListing($request)
        );

        return back()->with(
            [
                'message' => $listing['message'],
                'status' => $listing['status']
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing): InertiaResponse
    {
        Gate::authorize('view', $listing);

        return Inertia::render('Listing/Show', [
            'listing' => $listing,
            'user' => $listing->user->only(['id', 'name']),
            'canModify' => Auth::user() ? Auth::user()->can('modify', $listing) : false,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing): InertiaResponse
    {
        Gate::authorize('modify', $listing);

        return Inertia::render('Listing/Edit', [
            'listing' => $this->listingService->show($listing->id)['data'],
            'edit_listing_message' => session('message'),
            'status' => session('status'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Listing $listing, ListingRequest $request): RedirectResponse
    {
        Gate::authorize('modify', $listing);

        $list = $this->listingService->update(
            $listing->id,
            ListingDTO::makeFromRequestListing($request)
        );
        return back()->with(['message' => $list['message'], 'status' => $list['status']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing): RedirectResponse
    {
        Gate::authorize('modify', $listing);
        $list = $this->listingService->delete($listing->id);
        if ($list['status'] === true) {
            return redirect(route('home'))->with('message', $list['message']);
        }
        return back()->with('message', $list['message']);
    }
}
