<?php

namespace App\DTO\Listing;

use App\Http\Requests\StoreListingRequest;
use Illuminate\Http\UploadedFile;

class ListingCreateDTO
{
    public function __construct(
        public string $title,
        public ?string $desc,
        public ?string $tags = null,
        public ?string $email = null,
        public ?string $url = null,
        public ?UploadedFile $image = null
    ) {}

    public static function makeFromRequestListingCreate(StoreListingRequest $request): self
    {
        return new self(
            $request->input('title'),
            $request->input('desc'),
            $request->input('tags'),
            $request->input('email'),
            $request->input('link'),
            $request->file('image')
        );
    }
}
