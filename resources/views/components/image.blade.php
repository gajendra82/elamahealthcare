@props([
    'src' => null,
    'alt' => '',
    'placeholder' => 'default',
])

<img
    src="{{ asset_url($src, $placeholder) }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['loading' => 'lazy', 'decoding' => 'async']) }}
>
