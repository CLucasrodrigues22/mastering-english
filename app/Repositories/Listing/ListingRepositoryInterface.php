<?php

namespace App\Repositories\Listing;

use App\DTO\Listing\ListingCreateDTO;
use Illuminate\Http\Request;

interface ListingRepositoryInterface
{
    public function all(Request $request): array;
    public function create(ListingCreateDTO $dto, string $imagePath = null): array;
}
