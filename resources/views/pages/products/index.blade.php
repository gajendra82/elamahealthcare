@extends('layouts.app')

@section('content')
<x-hero-banner-carousel :banners="$banners" />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto mb-10 max-w-3xl text-center" data-aos="fade-up">
            <span class="section-label mb-4 inline-block">Products</span>
            <h1 class="font-heading text-3xl font-bold text-dark sm:text-4xl">Pharma Ready Dossiers</h1>
            <p class="mt-4 text-muted">Complete list of generic medicines and dosage forms from our ready dossier portfolio.</p>
        </div>

        <form method="GET" action="{{ route('products.index') }}" class="glass-card mb-10 rounded-2xl p-6" data-aos="fade-up">
            <div class="grid gap-4 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-7">
                    <label for="search" class="mb-2 block text-sm font-medium text-dark">Search Medicines</label>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-muted"></i>
                        <input id="search" type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by generic name..." class="form-input !pl-11">
                    </div>
                </div>
                <div class="lg:col-span-3">
                    <label for="category" class="mb-2 block text-sm font-medium text-dark">Dosage Form</label>
                    <select id="category" name="category" class="form-input">
                        <option value="">All Dosage Forms</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>
                                {{ $category->name }} ({{ $category->products_count ?? 0 }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:col-span-2 flex gap-2">
                    <button type="submit" class="btn-primary w-full">Search</button>
                    @if(($filters['search'] ?? '') || ($filters['category'] ?? ''))
                        <a href="{{ route('products.index') }}" class="btn-outline w-full text-center">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        <p class="mb-8 text-sm text-muted">
            Showing <span class="font-semibold text-dark">{{ $totalProducts }}</span> medicines
            @if($filters['category'] ?? false)
                in <span class="font-semibold text-primary">{{ $categories->firstWhere('slug', $filters['category'])?->name ?? ucfirst($filters['category']) }}</span>
            @endif
        </p>

        @if($totalProducts > 0)
            <div class="space-y-8">
                @php
                    $categoryIcons = [
                        'Tablet' => 'fas fa-tablets',
                        'Capsule' => 'fas fa-capsules',
                        'Injection' => 'fas fa-syringe',
                        'Drops' => 'fas fa-eye-dropper',
                        'Syrup' => 'fas fa-wine-bottle',
                        'Liquid' => 'fas fa-flask',
                        'Topical' => 'fas fa-hand-holding-medical',
                        'Infusion' => 'fas fa-vial',
                    ];
                @endphp

                @foreach($groupedProducts as $categoryName => $products)
                    <article
                        id="category-{{ \Illuminate\Support\Str::slug($categoryName) }}"
                        class="product-category-card glass-card rounded-2xl p-6 lg:p-8"
                        data-aos="fade-up"
                    >
                        <div class="product-category-card__header">
                            <div class="product-category-card__icon">
                                <i class="{{ $categoryIcons[$categoryName] ?? 'fas fa-pills' }}"></i>
                            </div>
                            <h2 class="product-category-card__title">{{ $categoryName }}</h2>
                            <p class="product-category-card__count">{{ $products->count() }} products</p>
                        </div>

                        @php
                            $items = $products->values();
                            $half = (int) ceil($items->count() / 2);
                            $columns = [$items->slice(0, $half), $items->slice($half)];
                        @endphp

                        <div class="mt-6 grid gap-6 md:grid-cols-2">
                            @foreach($columns as $column)
                                @if($column->isNotEmpty())
                                    <ul class="products-li">
                                        @foreach($column as $product)
                                            <li>{{ $product->product_name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="py-16 text-center">
                <i data-lucide="search-x" class="mx-auto h-12 w-12 text-muted"></i>
                <p class="mt-4 text-lg font-medium text-dark">No medicines found</p>
                <p class="text-sm text-muted">Try adjusting your search or choose a different dosage form.</p>
                <a href="{{ route('products.index') }}" class="btn-primary mt-6 inline-flex">Show All Medicines</a>
            </div>
        @endif
    </div>
</section>

<x-cta-section primaryLabel="Request Product Information" primaryUrl="/contact" />
@endsection
