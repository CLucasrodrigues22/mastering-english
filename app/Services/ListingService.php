<?php

namespace App\Services;

use App\DTO\Listing\ListingDTO;
use App\Helpers\ListingsHelper;
use App\Repositories\Listing\ListingRepositoryInterface;
use Illuminate\Http\Request;

class ListingService
{
    public function __construct(
        protected ListingRepositoryInterface $listingRepository,
        protected ListingsHelper $listingHelper
    )
    {}

    public function getAll(Request $request): array
    {
        return $this->listingRepository->all($request);
    }

    public function show(int $id): array
    {
        return $this->listingRepository->show($id);
    }

    public function create(ListingDTO $dto): array
    {
        $imagePath = null;
        if ($dto->image) {
            $imagePath = $this->listingHelper->saveFile($dto->image, "/images/listings");
        }

        if (!empty($dto->tags)) {
            $dto->tags = $this->listingHelper->prepareTags($dto->tags);
        }

        return $this->listingRepository->create($dto, $imagePath);

    }

    public function update(int $id, ListingDTO $dto): array
    {
        $imagePath = $this->show($id)['data']['image'];

        if ($dto->image) {
            if ($imagePath) {
                $this->listingHelper->deleteImage($imagePath);
            }
            $imagePath = $this->listingHelper->saveFile($dto->image, "/images/listings");
        }

        return $this->listingRepository->update($id, $dto, $imagePath);
    }


    public function delete(int $id): array
    {
        $image = $this->show($id);
        if($image['status'] === false)
        {
            return $image;
        }
        $this->listingHelper->deleteImage($image['data']['image']);
        return $this->listingRepository->delete($id);
    }
}
