@props(['testimonial'])

<div {{ $attributes->merge(['class' => 'glass-card h-full rounded-2xl p-6 lg:p-8']) }}>
    <div class="mb-4 flex gap-1 text-accent">
        @for($i = 0; $i < 5; $i++)
            <i class="fas fa-star text-sm"></i>
        @endfor
    </div>
    <blockquote class="text-dark-muted leading-relaxed">
        "{{ $testimonial['quote'] }}"
    </blockquote>
    <div class="mt-6 flex items-center gap-4 border-t border-border pt-6">
        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 font-heading font-bold text-primary">
            {{ strtoupper(substr($testimonial['name'], 0, 1)) }}
        </div>
        <div>
            <p class="font-heading font-semibold text-dark">{{ $testimonial['name'] }}</p>
            <p class="text-sm text-muted">{{ $testimonial['role'] ?? '' }}{{ !empty($testimonial['company']) ? ', ' . $testimonial['company'] : '' }}</p>
        </div>
    </div>
</div>
