@props([
    'src' => null,
    'alt' => '',
    'placeholder' => 'default',
])

<img
    src="{{ asset_url($src, $placeholder) }}"
    alt="{{ $alt }}"
    {{ $attributes }}
    loading="lazy"
    decoding="async"
>
