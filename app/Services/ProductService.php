<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

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

    public function groupedByCategory(?string $search = null, int|string|null $category = null): SupportCollection
    {
        return $this->productRepository->groupedByCategory($search, $category);
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
            'serial' => $product->sort_order,
            'name' => $product->product_name,
            'category' => $product->categoryRelation?->name ?? $product->category,
            'dosage_form' => $product->dosage,
            'url' => route('products.show', $product->slug),
        ];
    }

    public function formatCollection(Collection $products): array
    {
        return $products->map(fn (Product $product) => $this->formatForView($product))->all();
    }
}
