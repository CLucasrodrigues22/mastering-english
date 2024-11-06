<?php

namespace App\Repositories\Listing;

use App\DTO\Listing\ListingCreateDTO;
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

    public function show(int $id): array
    {
        try {
            $list = $this->model->with('user')->find($id);
            if (!$list) {
                return [
                    'status' => false,
                    'message' => 'List not found.',
                ];
            }

            return [
                'status' => true,
                'data' => $list->with('user')->first()
            ];
        } catch (\Exception $e)
        {
            return [
                'status' => false,
                'message' => 'Failed to retrieve listing data.',
            ];
        }
    }

    public function create(ListingCreateDTO $dto, string $imagePath = null): array
    {
        try {
            $attributes = (array) $dto;
            $attributes['user_id'] = auth()->id();
            if($imagePath) {
                $attributes['image'] = $imagePath;
            }
            $this->model->create($attributes);

            return [
                'status' => true,
                'message' => 'Listing has been created successfully.',
            ];
        } catch (\Exception $e)
        {
            return [
                'status' => false,
                'message' => 'Failed to create listing.',
            ];
        }
    }
}
