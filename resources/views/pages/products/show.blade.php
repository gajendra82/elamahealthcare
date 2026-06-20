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
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="glass-card rounded-3xl p-8 lg:p-12" data-aos="fade-up">
            @if(!empty($product['serial']))
                <p class="text-sm font-medium text-muted">S.No. {{ $product['serial'] }}</p>
            @endif
            <h1 class="mt-2 font-heading text-3xl font-bold text-dark sm:text-4xl">{{ $product['name'] }}</h1>
            @if(!empty($product['dosage_form']))
                <p class="mt-4 text-lg text-muted">
                    <span class="font-semibold text-dark">Dosage Form:</span> {{ $product['dosage_form'] }}
                </p>
            @endif
            @if(!empty($product['category']))
                <p class="mt-2 text-sm text-muted">
                    <span class="font-semibold text-dark">Category:</span> {{ $product['category'] }}
                </p>
            @endif

            <a href="{{ url('/contact') }}" class="btn-primary mt-10 inline-flex">Request Product Information</a>
            <a href="{{ route('products.index') }}" class="btn-outline ml-3 mt-10 inline-flex">Back to Product List</a>
        </div>
    </div>
</section>
@endsection
