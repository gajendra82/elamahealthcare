@extends('layouts.app')

@section('content')
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
                    <x-image :src="$product['image_path'] ?? null" placeholder="product" :alt="$product['name']" class="aspect-square w-full object-cover" />
                </div>
            </div>
            <div data-aos="fade-left">
                <span class="section-label mb-4 inline-block">{{ $product['category'] }}</span>
                <h1 class="font-heading text-3xl font-bold text-dark sm:text-4xl">{{ $product['name'] }}</h1>
                @if(!empty($product['strength']))
                    <p class="mt-3 text-lg font-medium text-primary">{{ $product['strength'] }}</p>
                @endif
                <p class="mt-6 leading-relaxed text-muted">{{ $product['description'] }}</p>

                @if(!empty($product['composition']))
                    <div class="mt-8">
                        <h2 class="font-heading text-lg font-semibold text-dark">Composition</h2>
                        <p class="mt-2 text-muted">{{ $product['composition'] }}</p>
                    </div>
                @endif

                @if(!empty($product['packaging']))
                    <div class="mt-6">
                        <h2 class="font-heading text-lg font-semibold text-dark">Packaging</h2>
                        <p class="mt-2 text-muted">{{ $product['packaging'] }}</p>
                    </div>
                @endif

                @if(!empty($product['format']))
                    <div class="mt-6">
                        <h2 class="font-heading text-lg font-semibold text-dark">Format</h2>
                        <p class="mt-2 text-muted">{{ $product['format'] }}</p>
                    </div>
                @endif

                <a href="{{ url('/contact') }}" class="btn-primary mt-10 inline-flex">Request Information</a>
            </div>
        </div>

        @if(count($related))
            <div class="mt-20">
                <x-section-heading label="Related" title="Related Products" />
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($related as $item)
                        <x-product-card :product="$item" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
