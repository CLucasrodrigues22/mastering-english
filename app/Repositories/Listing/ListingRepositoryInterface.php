<?php

namespace App\Repositories\Listing;

use Illuminate\Http\Request;

interface ListingRepositoryInterface
{
    public function all(Request $request): array;
}
