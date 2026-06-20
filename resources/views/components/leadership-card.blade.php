@props(['leader'])

<div {{ $attributes->merge(['class' => 'glass-card hover-lift overflow-hidden rounded-2xl']) }} data-aos="fade-up">
    <div class="relative aspect-[3/4] overflow-hidden bg-gradient-to-br from-primary/10 to-secondary/10">
        <img
            src="{{ $leader['photo'] ?? asset('images/leadership/default.jpg') }}"
            alt="{{ $leader['name'] }}"
            class="h-full w-full object-cover object-top"
            loading="lazy"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-dark/80 via-transparent to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
            <h3 class="font-heading text-xl font-bold">{{ $leader['name'] }}</h3>
            <p class="mt-1 text-sm text-accent">{{ $leader['title'] }}</p>
        </div>
    </div>
    <div class="p-6">
        @if(!empty($leader['qualification']))
            <p class="text-sm font-semibold text-primary">{{ $leader['qualification'] }}</p>
        @endif
        @if(!empty($leader['bio']))
            <p class="mt-3 text-sm leading-relaxed text-muted">{{ $leader['bio'] }}</p>
        @endif
        @if(!empty($leader['highlights']))
            <ul class="mt-4 space-y-2 border-t border-border pt-4">
                @foreach($leader['highlights'] as $highlight)
                    <li class="flex items-start gap-2 text-sm text-dark-muted">
                        <i data-lucide="award" class="mt-0.5 h-4 w-4 shrink-0 text-secondary"></i>
                        {{ $highlight }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
