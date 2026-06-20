<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function search(
        ?string $search = null,
        int|string|null $category = null,
        bool $alphabetical = true,
        int $perPage = 24
    ): LengthAwarePaginator {
        $query = Product::query()
            ->with('categoryRelation')
            ->active()
            ->search($search);

        if ($category !== null && $category !== '' && $category !== 'all') {
            $query->inCategory($category);
        }

        if ($alphabetical) {
            $query->alphabetical();
        } else {
            $query->latest();
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function findBySlug(string $slug): ?Product
    {
        return Product::query()
            ->with('categoryRelation')
            ->active()
            ->where('slug', $slug)
            ->first();
    }

    public function relatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::query()
            ->with('categoryRelation')
            ->active()
            ->where('id', '!=', $product->id)
            ->when(
                $product->category_id,
                fn ($query) => $query->where('category_id', $product->category_id),
                fn ($query) => $query->where('category', $product->category)
            )
            ->alphabetical()
            ->limit($limit)
            ->get();
    }

    public function countActive(): int
    {
        return Product::query()->active()->count();
    }
}
