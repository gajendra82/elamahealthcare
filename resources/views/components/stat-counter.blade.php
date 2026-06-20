@props([
    'count',
    'suffix' => '',
    'prefix' => '',
    'label',
    'icon' => null,
    'decimal' => 0,
])

<div {{ $attributes->merge(['class' => 'glass-card rounded-2xl p-6 lg:p-8 text-center hover-lift']) }} data-aos="fade-up">
    @if($icon)
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-primary/10 text-primary">
            <i class="{{ $icon }} text-xl"></i>
        </div>
    @endif
    <div class="font-heading text-4xl font-bold text-primary lg:text-5xl">
        <span
            data-count="{{ $count }}"
            data-suffix="{{ $suffix }}"
            data-prefix="{{ $prefix }}"
            @if($decimal) data-decimal="{{ $decimal }}" @endif
        >0</span>
    </div>
    <p class="mt-2 font-medium text-muted">{{ $label }}</p>
</div>
