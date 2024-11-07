<?php

namespace App\Repositories\Listing;

use App\DTO\Listing\ListingDTO;
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
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Failed to retrieve listing data.',
            ];
        }
    }


    public function show(int $id): array
    {
        try {
            $list = $this->model->with('user')->find($id)->toArray();
            if (!$list) {
                return [
                    'status' => false,
                    'message' => 'List not found.',
                ];
            }
            return [
                'status' => true,
                'data' => $list
            ];
        } catch (\Exception $e)
        {
            return [
                'status' => false,
                'message' => 'Failed to retrieve listing data.',
            ];
        }
    }

    public function create(ListingDTO $dto, string $imagePath = null): array
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

    public function update(int $id, ListingDTO $dto, string $imagePath = null): array
    {
        try {
            $attributes = (array) $dto;
            $list = $this->model->find($id);

            if ($list) {
                if ($imagePath) {
                    $attributes['image'] = $imagePath;
                }
                $list->update($attributes);

                return [
                    'status' => true,
                    'message' => 'Listing has been updated successfully.',
                ];
            }

            return [
                'status' => false,
                'message' => 'Listing not found.',
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Failed to update listing.',
            ];
        }
    }
}
