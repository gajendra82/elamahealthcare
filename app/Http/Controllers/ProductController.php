<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Repositories\CategoryRepository;
use App\Services\ProductService;
use App\Services\SeoService;
use App\Support\CategorySlug;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly CategoryRepository $categoryRepository,
        private readonly SeoService $seoService
    ) {}

    public function index(Request $request)
    {
        $search = $request->string('search')->toString() ?: null;
        $category = CategorySlug::resolve($request->input('category'));

        $groupedProducts = $this->productService->groupedByCategory($search, $category);
        $totalProducts = $groupedProducts->flatten()->count();

        return view('pages.products.index', [
            'seo' => $this->seoService->forPage(
                'Products | Elama Healthcare',
                'Explore our pharma ready dossiers and generic medicine portfolio across key dosage forms.'
            ),
            'banners' => Banner::query()->active()->ordered()->get(),
            'groupedProducts' => $groupedProducts,
            'totalProducts' => $totalProducts,
            'categories' => $this->categoryRepository->activeWithProductCounts(),
            'filters' => [
                'search' => $search,
                'category' => $category,
            ],
        ]);
    }

    public function show(string $slug)
    {
        $product = $this->productService->findBySlug($slug);

        abort_if(! $product, 404);

        $formatted = $this->productService->formatForView($product);

        return view('pages.products.show', [
            'seo' => $this->seoService->forPage(
                "{$product->product_name} | Elama Healthcare",
                $product->product_name,
                null,
                route('products.show', $product->slug),
                'product',
                $this->seoService->productSchema($formatted)
            ),
            'product' => $formatted,
        ]);
    }
}
