<?php

namespace App\Repositories\Listing;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingEloquentORM implements ListingRepositoryInterface
{
    public function __construct(protected Listing $model)
    {}

    public function all(Request $request): array
    {
        try {
            $listings = $this->model->with('user')->paginate(6);

            return [
                'success' => true,
                'data' => $listings
            ];
        } catch (\Exception $e)
        {
            return [
                'status' => false,
                'message' => 'Failed to retrieve listing data.',
            ];
        }
    }
}
