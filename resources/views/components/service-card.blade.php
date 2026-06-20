@props(['service'])

<div {{ $attributes->merge(['class' => 'glass-card hover-lift group rounded-2xl p-6 lg:p-8']) }} data-aos="fade-up">
    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-primary-light text-white shadow-lg shadow-primary/20 transition-transform group-hover:scale-110">
        <i class="{{ $service['icon'] ?? 'fas fa-capsules' }} text-xl"></i>
    </div>
    <h3 class="font-heading text-xl font-semibold text-dark">{{ $service['title'] }}</h3>
    <p class="mt-3 text-sm leading-relaxed text-muted">{{ $service['description'] }}</p>
    @if(!empty($service['features']))
        <ul class="mt-4 space-y-2">
            @foreach($service['features'] as $feature)
                <li class="flex items-start gap-2 text-sm text-dark-muted">
                    <i class="fas fa-check-circle mt-0.5 text-secondary"></i>
                    {{ $feature }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
