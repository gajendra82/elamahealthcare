<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::query()
            ->with('categoryRelation')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->search($request->string('search')->toString());
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->integer('category_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return response()->json($products);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $data = $this->prepareData($request->validated());

        $product = Product::query()->create($data);

        return response()->json([
            'message' => 'Product created successfully.',
            'data' => $product->load('categoryRelation'),
        ], 201);
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json($product->load('categoryRelation'));
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $data = $this->prepareData($request->validated(), $product);
        $product->update($data);

        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => $product->fresh()->load('categoryRelation'),
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }

    private function prepareData(array $data, ?Product $product = null): array
    {
        if (empty($data['slug'])) {
            $data['slug'] = $this->uniqueSlug($data['product_name'], $product?->id);
        }

        return $data;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $counter = 1;

        while (
            Product::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
