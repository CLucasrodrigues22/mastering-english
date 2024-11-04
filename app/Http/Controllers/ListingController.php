<?php

namespace App\Http\Controllers;

use App\DTO\Listing\ListingCreateDTO;
use App\Http\Requests\StoreListingRequest;
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
    public function store(StoreListingRequest $request): RedirectResponse
    {
        $listing = $this->listingService->create(
            ListingCreateDTO::makeFromRequestListingCreate($request)
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
    public function show(Listing $listing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
    }
}
