@extends('layouts.app')

@section('content')
@php
    $product = $product ?? [
        'name' => 'Metformin Tablets',
        'category' => 'Tablets',
        'strength' => '500mg, 850mg, 1000mg',
        'description' => 'Metformin is a first-line oral antidiabetic agent belonging to the biguanide class. It works by decreasing glucose production in the liver, decreasing intestinal absorption of glucose, and improving insulin sensitivity.',
        'image' => asset('images/products/metformin.jpg'),
        'therapeutic' => 'Antidiabetic',
        'composition' => 'Metformin Hydrochloride IP',
        'pack_size' => '10 x 10 Tablets',
        'storage' => 'Store below 30°C in a dry place. Protect from light and moisture.',
        'indications' => ['Type 2 Diabetes Mellitus', 'Polycystic Ovary Syndrome (PCOS)', 'Prediabetes management'],
    ];

    $related = [
        ['name' => 'Glimepiride Tablets', 'category' => 'Tablets', 'strength' => '1mg, 2mg, 4mg', 'description' => 'Sulfonylurea antidiabetic agent.', 'image' => asset('images/products/glimepiride.jpg'), 'url' => url('/products/glimepiride-tablets')],
        ['name' => 'Sitagliptin Tablets', 'category' => 'Tablets', 'strength' => '50mg, 100mg', 'description' => 'DPP-4 inhibitor for type 2 diabetes.', 'image' => asset('images/products/sitagliptin.jpg'), 'url' => url('/products/sitagliptin-tablets')],
        ['name' => 'Gliclazide Tablets', 'category' => 'Tablets', 'strength' => '40mg, 80mg', 'description' => 'Second-generation sulfonylurea.', 'image' => asset('images/products/gliclazide.jpg'), 'url' => url('/products/gliclazide-tablets')],
        ['name' => 'Pioglitazone Tablets', 'category' => 'Tablets', 'strength' => '15mg, 30mg', 'description' => 'Thiazolidinedione antidiabetic agent.', 'image' => asset('images/products/pioglitazone.jpg'), 'url' => url('/products/pioglitazone-tablets')],
    ];
@endphp

<section class="gradient-hero pt-32 pb-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[
            ['label' => 'Products', 'url' => url('/products')],
            ['label' => $product['name']],
        ]" />
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-2">
            <div data-aos="fade-right">
                <div class="glass-card overflow-hidden rounded-3xl">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full object-cover">
                </div>
            </div>
            <div data-aos="fade-left">
                <span class="section-label mb-4 inline-block">{{ $product['category'] }}</span>
                <h1 class="font-heading text-3xl font-bold text-dark sm:text-4xl">{{ $product['name'] }}</h1>
                <p class="mt-2 text-lg font-medium text-primary">{{ $product['strength'] }}</p>
                <p class="mt-6 leading-relaxed text-muted">{{ $product['description'] }}</p>

                <div class="mt-8 space-y-4">
                    @foreach([
                        'Therapeutic Class' => $product['therapeutic'] ?? 'N/A',
                        'Composition' => $product['composition'] ?? 'N/A',
                        'Pack Size' => $product['pack_size'] ?? 'N/A',
                        'Storage' => $product['storage'] ?? 'N/A',
                    ] as $label => $value)
                        <div class="flex border-b border-border pb-3">
                            <span class="w-40 shrink-0 text-sm font-semibold text-dark">{{ $label }}</span>
                            <span class="text-sm text-muted">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>

                @if(!empty($product['indications']))
                    <div class="mt-8">
                        <h3 class="font-heading font-semibold text-dark">Indications</h3>
                        <ul class="mt-3 space-y-2">
                            @foreach($product['indications'] as $indication)
                                <li class="flex items-start gap-2 text-sm text-muted">
                                    <i class="fas fa-check-circle mt-0.5 text-secondary"></i>{{ $indication }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ url('/contact') }}" class="btn-primary">Request Information</a>
                    <a href="{{ url('/products') }}" class="btn-outline">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Related" title="Related Products" />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($related as $item)
                <x-product-card :product="$item" />
            @endforeach
        </div>
    </div>
</section>

<x-cta-section />
@endsection
