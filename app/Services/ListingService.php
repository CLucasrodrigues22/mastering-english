<?php

namespace App\Services;

use App\DTO\Listing\ListingCreateDTO;
use App\Helpers\ListingsHelper;
use App\Repositories\Listing\ListingRepositoryInterface;
use Illuminate\Http\Request;

class ListingService
{
    public function __construct(protected ListingRepositoryInterface $listingRepository, protected ListingsHelper $listingHelper)
    {}

    public function getAll(Request $request): array
    {
        return $this->listingRepository->all($request);
    }

    public function show(int $id): array
    {
        return $this->listingRepository->show($id);
    }

    public function create(ListingCreateDTO $dto): array
    {
        $imagePath = null;
        if ($dto->image) {
            $imagePath = $this->listingHelper->saveImage($dto->image, '/images/listings');
        }

        if (!empty($dto->tags)) {
            $dto->tags = $this->listingHelper->prepareTags($dto->tags);
        }

        return $this->listingRepository->create($dto, $imagePath);

    }
}
