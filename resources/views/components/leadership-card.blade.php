@props(['leader'])

<div {{ $attributes->merge(['class' => 'glass-card hover-lift overflow-hidden rounded-2xl']) }} data-aos="fade-up">
    <div class="leadership-card__photo relative aspect-[4/5] overflow-hidden bg-slate-200">
        <x-image
            :src="$leader['photo_path'] ?? null"
            placeholder="leadership"
            :alt="$leader['name']"
            class="leadership-card__image absolute inset-0 h-full w-full object-cover object-[center_18%]"
            width="960"
            height="1200"
        />
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-dark/80 via-dark/20 to-transparent"></div>
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
