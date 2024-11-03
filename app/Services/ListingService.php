<?php

namespace App\Services;

use App\Repositories\Listing\ListingRepositoryInterface;
use Illuminate\Http\Request;

class ListingService
{
    public function __construct(protected ListingRepositoryInterface $repository)
    {}

    public function getAll(Request $request): array
    {
        return $this->repository->all($request);
    }
}
