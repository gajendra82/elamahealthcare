<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {}

    public function list(
        ?string $search = null,
        int|string|null $category = null,
        bool $alphabetical = true,
        int $perPage = 24
    ): LengthAwarePaginator {
        return $this->productRepository->search($search, $category, $alphabetical, $perPage);
    }

    public function findBySlug(string $slug): ?Product
    {
        return $this->productRepository->findBySlug($slug);
    }

    public function relatedProducts(Product $product, int $limit = 4): Collection
    {
        return $this->productRepository->relatedProducts($product, $limit);
    }

    public function formatForView(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->product_name,
            'category' => $product->categoryRelation?->name ?? $product->category,
            'strength' => $product->dosage,
            'description' => $product->description ?: $product->product_name,
            'composition' => $product->composition,
            'packaging' => $product->packaging,
            'format' => $product->format,
            'image' => asset_url($product->image, 'product'),
            'image_path' => $product->image,
            'url' => route('products.show', $product->slug),
        ];
    }

    public function formatCollection(Collection $products): array
    {
        return $products->map(fn (Product $product) => $this->formatForView($product))->all();
    }
}
