@props([
    'title' => 'Ready to Partner With Us?',
    'subtitle' => 'Connect with Elama Healthcare for quality pharmaceutical solutions tailored to your market needs.',
    'primaryLabel' => 'Contact Us',
    'primaryUrl' => '/contact',
    'secondaryLabel' => null,
    'secondaryUrl' => null,
])

<section class="section-padding relative overflow-hidden">
    <div class="absolute inset-0 gradient-hero"></div>
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -right-20 -top-20 h-96 w-96 rounded-full bg-accent blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-96 w-96 rounded-full bg-secondary blur-3xl"></div>
    </div>
    <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8" data-aos="zoom-in">
        <h2 class="font-heading text-3xl font-bold text-white sm:text-4xl lg:text-5xl">{{ $title }}</h2>
        <p class="mx-auto mt-4 max-w-2xl text-lg text-white/80">{{ $subtitle }}</p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ $primaryUrl }}" class="btn-secondary">
                {{ $primaryLabel }}
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
            @if($secondaryLabel && $secondaryUrl)
                <a href="{{ $secondaryUrl }}" class="btn-outline border-white text-white hover:bg-white hover:text-primary">
                    {{ $secondaryLabel }}
                </a>
            @endif
        </div>
    </div>
</section>
