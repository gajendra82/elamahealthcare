@props(['seo' => []])

@php
    $title = $seo['title'] ?? 'Elama Healthcare Solutions Pvt. Ltd.';
    $description = $seo['description'] ?? 'Global Healthcare Solutions Built on Trust, Quality & Innovation. Delivering affordable quality pharmaceutical products across the globe.';
    $canonical = $seo['canonical'] ?? url()->current();
    $image = $seo['image'] ?? asset_url(config('assets.seo_image'), 'logo');
    $type = $seo['type'] ?? 'website';
    $schema = $seo['schema'] ?? [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Elama Healthcare Solutions Pvt. Ltd.',
        'url' => url('/'),
        'logo' => asset_url(config('assets.logo'), 'logo'),
        'description' => $description,
        'foundingDate' => '1986',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => config('contact.address'),
            'addressLocality' => config('contact.locality'),
            'addressRegion' => config('contact.region'),
            'addressCountry' => config('contact.country'),
        ],
        'telephone' => config('contact.phone'),
        'email' => config('contact.email'),
    ];
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:site_name" content="Elama Healthcare">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
