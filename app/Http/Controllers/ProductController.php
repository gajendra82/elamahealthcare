<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use App\Services\ProductService;
use App\Services\SeoService;
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
        $category = $request->input('category');
        $alphabetical = $request->boolean('alpha', true);

        $products = $this->productService->list(
            search: $search,
            category: $category,
            alphabetical: $alphabetical,
            perPage: 24
        );

        return view('pages.products.index', [
            'seo' => $this->seoService->forPage(
                'Products | Elama Healthcare',
                'Explore our diversified pharmaceutical portfolio across key therapeutic segments.'
            ),
            'products' => $this->productService->formatCollection($products->getCollection()),
            'productsPaginator' => $products,
            'categories' => $this->categoryRepository->activeWithProductCounts(),
            'filters' => [
                'search' => $search,
                'category' => $category,
                'alpha' => $alphabetical,
            ],
        ]);
    }

    public function show(string $slug)
    {
        $product = $this->productService->findBySlug($slug);

        abort_if(! $product, 404);

        $formatted = $this->productService->formatForView($product);
        $related = $this->productService->formatCollection(
            $this->productService->relatedProducts($product)
        );

        return view('pages.products.show', [
            'seo' => $this->seoService->forPage(
                "{$product->product_name} | Elama Healthcare",
                $product->description ?: $product->product_name,
                $product->image,
                route('products.show', $product->slug),
                'product',
                $this->seoService->productSchema($formatted)
            ),
            'product' => $formatted,
            'related' => $related,
        ]);
    }
}
