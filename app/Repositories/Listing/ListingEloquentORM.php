<?php

namespace App\Repositories\Listing;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ListingEloquentORM implements ListingRepositoryInterface
{
    public function __construct(protected Listing $model)
    {}

    public function all(Request $request): array
    {
        try {
            $listings = $this->model->whereHas('user', function (Builder $query) {
                $query->where('role', '!=', 'suspended');
            })
                ->with('user')
                ->where('approved', true)
                ->filter(request(['search', 'user_id', 'tag']))
                ->latest()
                ->paginate(6)
                ->withQueryString();

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
