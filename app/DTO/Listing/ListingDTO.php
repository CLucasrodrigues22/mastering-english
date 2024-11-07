<?php

namespace App\DTO\Listing;

use App\Http\Requests\ListingRequest;
use Illuminate\Http\UploadedFile;

class ListingDTO
{
    public function __construct(
        public string $title,
        public ?string $desc,
        public ?string $tags = null,
        public ?string $email = null,
        public ?string $url = null,
        public ?UploadedFile $image = null
    ) {}

    public static function makeFromRequestListing(ListingRequest $request): self
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
