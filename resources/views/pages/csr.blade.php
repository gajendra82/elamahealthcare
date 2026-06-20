@extends('layouts.app')

@section('content')
<section class="gradient-hero pt-32 pb-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <x-breadcrumb :items="[['label' => 'CSR Activities']]" />
        <div class="max-w-3xl" data-aos="fade-up">
            <span class="section-label mb-4 inline-block !text-accent !bg-white/10">Community</span>
            <h1 class="font-heading text-4xl font-bold text-white sm:text-5xl">Corporate Social Responsibility</h1>
            <p class="mt-4 text-lg text-white/80">Our business philosophy serves a social responsibility — sustainability is intrinsic to how we operate.</p>
        </div>
    </div>
</section>
<x-wave-divider />

<section class="section-padding bg-background">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center mb-12" data-aos="fade-up">
            <p class="text-lg leading-relaxed text-muted">
                Our basic business philosophy, by its very nature, serves a social responsibility — we have a far better reason than profits alone to drive our performance. Sustainability is not a trend we blindly follow; it is intrinsic to how we have operated since the genesis of the organization in 1986.
            </p>
        </div>

        {{-- Masonry Gallery with LightGallery --}}
        <div id="csr-gallery" class="columns-1 gap-4 sm:columns-2 lg:columns-3">
            @foreach([
                ['src' => 'csr-1.jpg', 'title' => 'Health Camp - Navi Mumbai', 'desc' => 'Free medical checkup camp for underserved communities'],
                ['src' => 'csr-2.jpg', 'title' => 'Medicine Donation Drive', 'desc' => 'Essential medicines donated to rural healthcare centers'],
                ['src' => 'csr-3.jpg', 'title' => 'School Health Program', 'desc' => 'Health awareness sessions for school children'],
                ['src' => 'csr-4.jpg', 'title' => 'Women Wellness Initiative', 'desc' => 'Gynecology health screening for women in rural areas'],
                ['src' => 'csr-5.jpg', 'title' => 'Disaster Relief Support', 'desc' => 'Emergency medical supplies during natural disasters'],
                ['src' => 'csr-6.jpg', 'title' => 'Tree Plantation Drive', 'desc' => 'Environmental sustainability through green initiatives'],
                ['src' => 'csr-7.jpg', 'title' => 'Blood Donation Camp', 'desc' => 'Employee-led blood donation drive at corporate office'],
                ['src' => 'csr-8.jpg', 'title' => 'Elderly Care Program', 'desc' => 'Free medicines and health support for senior citizens'],
                ['src' => 'csr-9.jpg', 'title' => 'Community Pharmacy', 'desc' => 'Subsidized pharmacy services for low-income families'],
            ] as $photo)
                <a
                    href="{{ asset('images/csr/' . $photo['src']) }}"
                    class="gallery-item masonry-item group block overflow-hidden rounded-2xl"
                    data-sub-html="<h4>{{ $photo['title'] }}</h4><p>{{ $photo['desc'] }}</p>"
                    data-aos="fade-up"
                >
                    <img
                        src="{{ asset('images/csr/' . $photo['src']) }}"
                        alt="{{ $photo['title'] }}"
                        class="w-full rounded-2xl object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                    >
                    <div class="mt-2 px-1">
                        <p class="font-heading text-sm font-semibold text-dark">{{ $photo['title'] }}</p>
                        <p class="text-xs text-muted">{{ $photo['desc'] }}</p>
                    </div>
                </a>
            @endforeach
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
