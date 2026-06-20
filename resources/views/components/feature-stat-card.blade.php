@props([
    'icon',
    'title',
    'description',
])

<div {{ $attributes->merge(['class' => 'feature-stat-card']) }} data-aos="fade-up">
    <div class="feature-stat-card__icon">
        <i class="{{ $icon }}"></i>
    </div>
    <div class="feature-stat-card__body">
        <h3 class="feature-stat-card__title">{{ $title }}</h3>
        <div class="feature-stat-card__rule"></div>
        <p class="feature-stat-card__desc">{{ $description }}</p>
    </div>
</div>
