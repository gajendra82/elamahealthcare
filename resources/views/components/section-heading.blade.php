@props([
    'label' => null,
    'title',
    'subtitle' => null,
    'centered' => true,
    'light' => false,
])

<div @class(['max-w-3xl', 'mx-auto text-center' => $centered, 'mb-12 lg:mb-16' => true]) data-aos="fade-up">
    @if($label)
        <span @class(['section-label', 'mb-4 inline-block'])>{{ $label }}</span>
    @endif
    <h2 @class([
        'font-heading text-3xl font-bold tracking-tight sm:text-4xl lg:text-[2.75rem] lg:leading-tight',
        'text-white' => $light,
        'text-dark' => !$light,
    ])>{{ $title }}</h2>
    @if($subtitle)
        <p @class([
            'mt-4 text-lg leading-relaxed',
            'text-white/80' => $light,
            'text-muted' => !$light,
        ])>{{ $subtitle }}</p>
    @endif
</div>
