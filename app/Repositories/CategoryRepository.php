<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function activeWithProductCounts(): Collection
    {
        return Category::query()
            ->active()
            ->ordered()
            ->withCount(['products' => fn ($query) => $query->active()])
            ->get();
    }

    public function findBySlug(string $slug): ?Category
    {
        return Category::query()->active()->where('slug', $slug)->first();
    }
}
