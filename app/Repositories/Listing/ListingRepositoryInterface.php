<?php

namespace App\Repositories\Listing;

use App\DTO\Listing\ListingDTO;
use Illuminate\Http\Request;

interface ListingRepositoryInterface
{
    public function all(Request $request): array;
    public function show(int $id): array;
    public function create(ListingDTO $dto, string $imagePath = null): array;
    public function update(int $id, ListingDTO $dto, string $imagePath = null): array;
    public function delete(int $id): array;
}
