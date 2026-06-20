@props(['banners' => collect()])

@php
    $slides = $banners->isNotEmpty()
        ? $banners
        : collect(config('assets.hero_banners', []))->map(fn (array $slide, int $index) => (object) [
            'title' => $slide['title'] ?? 'Global Healthcare Solutions',
            'subtitle' => 'Built on Trust, Quality & Innovation',
            'image' => $slide['path'],
            'button_text' => $index === 0 ? 'Explore Products' : 'Learn More',
            'button_url' => $index === 0 ? '/products' : '/about',
        ]);
@endphp

<section class="premium-hero">
    <div class="hero-swiper premium-hero-swiper swiper">
        <div class="swiper-wrapper">
            @foreach($slides as $banner)
                @php
                    $paragraphs = array_values(array_filter(preg_split("/\r\n|\r|\n/", (string) ($banner->subtitle ?? ''))));
                @endphp
                <div class="swiper-slide">
                    <article class="premium-hero-slide">
                        <img
                            src="{{ asset_url($banner->image, 'hero') }}"
                            alt="{{ $banner->title }}"
                            class="premium-hero-slide__image"
                            width="1920"
                            height="750"
                            loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                            fetchpriority="{{ $loop->first ? 'high' : 'auto' }}"
                            decoding="async"
                        >
                        <div class="premium-hero-slide__shade" aria-hidden="true"></div>
                        <div class="premium-hero-slide__wave" aria-hidden="true">
                            <svg viewBox="0 0 800 700" preserveAspectRatio="none" class="h-full w-full">
                                <path d="M220,0 C420,120 520,260 640,420 C720,530 760,620 800,700 L800,0 Z" fill="#0B4F8C" opacity="0.92"/>
                                <path d="M280,0 C460,140 560,300 680,460 C740,550 770,630 800,700 L800,0 Z" fill="#1E6BB8" opacity="0.55"/>
                            </svg>
                        </div>
                        <div class="premium-hero-slide__dots" aria-hidden="true"></div>

                        <div class="premium-hero-slide__content mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                            <div class="max-w-2xl">
                                <p class="premium-hero-slide__eyebrow">Elama Healthcare Solutions Pvt. Ltd.</p>
                                <h1 class="premium-hero-slide__title">{{ $banner->title }}</h1>
                                <div class="premium-hero-slide__rule"></div>

                                @if(count($paragraphs) > 1)
                                    @foreach($paragraphs as $paragraph)
                                        <p class="premium-hero-slide__text">{{ $paragraph }}</p>
                                    @endforeach
                                @elseif(!empty($banner->subtitle))
                                    <p class="premium-hero-slide__text">{{ $banner->subtitle }}</p>
                                @endif

                                <div class="premium-hero-slide__actions">
                                    <a href="{{ url($banner->button_url ?: '/products') }}" class="btn-primary">
                                        {{ $banner->button_text ?: 'Explore Products' }}
                                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                    </a>
                                    <a href="{{ url('/services') }}" class="btn-outline premium-hero-slide__btn-outline">
                                        Our Services
                                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="swiper-pagination premium-hero-pagination"></div>
        <button type="button" class="swiper-button-prev premium-hero-nav" aria-label="Previous slide"></button>
        <button type="button" class="swiper-button-next premium-hero-nav" aria-label="Next slide"></button>
    </div>
</section>
