<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'desc',
        'tags',
        'email',
        'link',
        'image',
        'user_id',
        'approved',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function scopeFilter($query, array $filters): void
    {
        if ($filters['search'] ?? false) {
            $query->where(function ($q) {
                $q
                    ->where('title', 'like', "%" . request('search') . "%")
                    ->orWhere('desc', 'like', "%" . request('search') . "%");
            });
        }

        if ($filters['user_id'] ?? false) {
            $query->where('user_id', request('user_id'));
        }

        if ($filters['tag'] ?? false) {
            $tags = explode(',', request('tag')); // Separando as tags por vírgula
            foreach ($tags as $tag) {
                $query->where('tags', 'like', "%{$tag}%");
            }
        }

        if ($filters['disapproved'] ?? false) {
            $query->where('approved', false);
        }
    }
}
