@extends('layouts.app')

@section('content')
{{-- CSR Hero Banner --}}
<section class="relative overflow-hidden bg-dark">
    <div class="csr-hero-swiper swiper h-[50vh] min-h-[360px] w-full lg:min-h-[480px]">
        <div class="swiper-wrapper">
            @forelse($galleries as $photo)
                <div class="swiper-slide relative">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset_url($photo->image, 'csr') }}')"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-[#062F54]/90 via-[#0B4F8C]/75 to-[#062F54]/50"></div>
                </div>
            @empty
                @foreach(config('assets.csr', []) as $csrImage)
                    <div class="swiper-slide relative">
                        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset_url($csrImage, 'csr') }}')"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-[#062F54]/90 via-[#0B4F8C]/75 to-[#062F54]/50"></div>
                    </div>
                @endforeach
            @endforelse
        </div>
        <div class="swiper-pagination !bottom-8"></div>
        <div class="swiper-button-prev !text-white"></div>
        <div class="swiper-button-next !text-white"></div>
    </div>

    <div class="pointer-events-none absolute inset-0 z-10 flex items-end">
        <div class="mx-auto w-full max-w-7xl px-4 pb-16 pt-32 sm:px-6 lg:px-8">
            <div class="pointer-events-auto max-w-3xl" data-aos="fade-up">
                <x-breadcrumb :items="[['label' => 'CSR Activities']]" class="[&_a]:text-white/70 [&_a:hover]:text-white [&_span]:text-white [&_li]:text-white/50" />
                <span class="section-label mb-4 mt-6 inline-block !border-white/20 !bg-white/10 !text-accent">Community</span>
                <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Corporate Social Responsibility</h1>
                <p class="mt-4 text-lg text-white/85">Our business philosophy serves a social responsibility — sustainability is intrinsic to how we operate.</p>
            </div>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center mb-12" data-aos="fade-up">
            <p class="text-lg leading-relaxed text-muted">
                Our basic business philosophy, by its very nature, serves a social responsibility — we have a far better reason than profits alone to drive our performance. Sustainability is not a trend we blindly follow; it is intrinsic to how we operate as a responsible global healthcare organization.
            </p>
        </div>

        <x-section-heading label="Gallery" title="CSR Activity Gallery" subtitle="Community health camps, medical screening drives, and outreach programs." />

        {{-- Masonry Gallery with LightGallery --}}
        <div id="csr-gallery" class="columns-1 gap-4 sm:columns-2 lg:columns-3">
            @forelse($galleries as $photo)
                <a
                    href="{{ asset_url($photo->image, 'csr') }}"
                    class="gallery-item masonry-item group mb-4 block overflow-hidden rounded-2xl break-inside-avoid"
                    data-sub-html="<h4>{{ $photo->title }}</h4><p>{{ $photo->description }}</p>"
                    data-aos="fade-up"
                >
                    <x-image
                        :src="$photo->image"
                        placeholder="csr"
                        :alt="$photo->title"
                        class="w-full rounded-2xl object-cover transition-transform duration-500 group-hover:scale-105"
                    />
                    <div class="mt-2 px-1">
                        <p class="font-heading text-sm font-semibold text-dark">{{ $photo->title }}</p>
                        <p class="text-xs text-muted">{{ $photo->description }}</p>
                    </div>
                </a>
            @empty
                @foreach(config('assets.csr', []) as $index => $csrImage)
                    <a
                        href="{{ asset_url($csrImage, 'csr') }}"
                        class="gallery-item masonry-item group mb-4 block overflow-hidden rounded-2xl break-inside-avoid"
                        data-aos="fade-up"
                    >
                        <x-image :src="$csrImage" placeholder="csr" alt="CSR Activity" class="w-full rounded-2xl object-cover" />
                    </a>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-section-heading label="Impact Areas" title="Our CSR Focus Areas" />
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach([
                ['icon' => 'fas fa-heartbeat', 'title' => 'Healthcare Access', 'desc' => 'Making medicines accessible to underserved communities'],
                ['icon' => 'fas fa-graduation-cap', 'title' => 'Health Education', 'desc' => 'Awareness programs on disease prevention and wellness'],
                ['icon' => 'fas fa-leaf', 'title' => 'Environment', 'desc' => 'Sustainable practices and environmental conservation'],
                ['icon' => 'fas fa-hands-helping', 'title' => 'Community Support', 'desc' => 'Disaster relief and community development initiatives'],
            ] as $area)
                <div class="glass-card hover-lift rounded-2xl p-6 text-center" data-aos="fade-up">
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-secondary/10 text-secondary">
                        <i class="{{ $area['icon'] }} text-xl"></i>
                    </div>
                    <h3 class="font-heading font-semibold text-dark">{{ $area['title'] }}</h3>
                    <p class="mt-2 text-sm text-muted">{{ $area['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<x-cta-section title="Join Our Mission" subtitle="Together we can make quality healthcare accessible to communities that need it most." />
@endsection
