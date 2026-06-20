@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'Products']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Portfolio</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Our Products</h1>
            <p class="mt-4 text-lg text-white/80">Diversified pharmaceutical portfolio across key therapeutic segments.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('products.index') }}" class="glass-card mb-10 rounded-2xl p-6" data-aos="fade-up">
            <div class="grid gap-4 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-5">
                    <label for="search" class="mb-2 block text-sm font-medium text-dark">Search Products</label>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-muted"></i>
                        <input id="search" type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by name..." class="form-input !pl-11">
                    </div>
                </div>
                <div class="lg:col-span-3">
                    <label for="category" class="mb-2 block text-sm font-medium text-dark">Category</label>
                    <select id="category" name="category" class="form-input">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>
                                {{ $category->name }} ({{ $category->products_count ?? 0 }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-dark">Sort</label>
                    <select name="alpha" class="form-input">
                        <option value="1" @selected($filters['alpha'] ?? true)>A–Z</option>
                        <option value="0" @selected(!($filters['alpha'] ?? true))>Latest</option>
                    </select>
                </div>
                <div class="lg:col-span-2">
                    <button type="submit" class="btn-primary w-full">Apply Filters</button>
                </div>
            </div>
        </form>

        <p class="mb-6 text-sm text-muted">
            Showing <span class="font-semibold text-dark">{{ $productsPaginator->total() }}</span> products
        </p>

        @if(count($products))
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($products as $product)
                    <div data-aos="fade-up">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $productsPaginator->withQueryString()->links() }}
            </div>
        @else
            <div class="py-16 text-center">
                <i data-lucide="search-x" class="mx-auto h-12 w-12 text-muted"></i>
                <p class="mt-4 text-lg font-medium text-dark">No products found</p>
                <p class="text-sm text-muted">Try adjusting your search or filters.</p>
            </div>
        @endif
    </div>
</section>

<x-cta-section primaryLabel="Request Product Information" primaryUrl="/contact" />
@endsection
