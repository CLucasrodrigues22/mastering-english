<?php

namespace App\Http\Controllers;

use App\DTO\Listing\ListingDTO;
use App\Http\Requests\ListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Services\ListingService;
use Illuminate\Http\{RedirectResponse, Request};
use Inertia\{Inertia, Response as InertiaResponse};

class ListingController extends Controller
{
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
    public function show(int $id): InertiaResponse
    {
        return Inertia::render('Listing/Show', [
            'listing' => $this->listingService->show($id)['data']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): InertiaResponse
    {
        return Inertia::render('Listing/Edit', [
            'listing' => $this->listingService->show($id)['data'],
            'edit_listing_message' => session('message'),
            'status' => session('status'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, ListingRequest $request): RedirectResponse
    {
        $list = $this->listingService->update(
            $id,
            ListingDTO::makeFromRequestListing($request)
        );
        return back()->with(['message' => $list['message'], 'status' => $list['status']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        dd($id);
    }
}
