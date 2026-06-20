@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6">
    @php
        $cards = [
            ['label' => 'Products', 'value' => $counts['products'], 'color' => 'bg-primary', 'route' => 'admin.products.index'],
            ['label' => 'Categories', 'value' => $counts['categories'], 'color' => 'bg-secondary', 'route' => 'admin.categories.index'],
            ['label' => 'Leadership', 'value' => $counts['leadership'], 'color' => 'bg-primary', 'route' => 'admin.leadership.index'],
            ['label' => 'Partners', 'value' => $counts['partners'], 'color' => 'bg-secondary', 'route' => 'admin.partners.index'],
            ['label' => 'News Articles', 'value' => $counts['news'], 'color' => 'bg-primary', 'route' => 'admin.news.index'],
            ['label' => 'CSR Gallery', 'value' => $counts['csr_gallery'], 'color' => 'bg-secondary', 'route' => 'admin.csr.index'],
            ['label' => 'Career Jobs', 'value' => $counts['career_jobs'], 'color' => 'bg-primary', 'route' => 'admin.jobs.index'],
            ['label' => 'Banners', 'value' => $counts['banners'], 'color' => 'bg-secondary', 'route' => 'admin.banners.index'],
            ['label' => 'Testimonials', 'value' => $counts['testimonials'], 'color' => 'bg-primary', 'route' => 'admin.testimonials.index'],
            ['label' => 'Contact Enquiries', 'value' => $counts['contact_enquiries'], 'color' => 'bg-secondary', 'route' => 'admin.enquiries.index'],
            ['label' => 'New Enquiries', 'value' => $counts['new_enquiries'], 'color' => 'bg-red-500', 'route' => 'admin.enquiries.index'],
            ['label' => 'Career Applications', 'value' => $counts['career_applications'], 'color' => 'bg-primary', 'route' => 'admin.jobs.index'],
        ];
    @endphp

    @foreach ($cards as $card)
        <a href="{{ route($card['route']) }}" class="block bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 group-hover:text-gray-700">{{ $card['label'] }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($card['value']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl {{ $card['color'] }} flex items-center justify-center text-white text-lg font-bold opacity-90">
                    {{ strtoupper(substr($card['label'], 0, 1)) }}
                </div>
            </div>
        </a>
    @endforeach
</div>

<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Welcome back, {{ Auth::user()->name }}</h2>
    <p class="text-gray-600 text-sm">Use the sidebar to manage products, content, enquiries, and site settings for Elama Healthcare.</p>
</div>
@endsection
