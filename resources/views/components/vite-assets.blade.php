@props([
    'assets' => ['resources/css/app.css', 'resources/js/app.js'],
])

@if (file_exists(public_path('build/manifest.json')))
    @vite($assets)
@elseif (file_exists(public_path('hot')))
    @vite($assets)
@else
    @php
        $manifest = [];
        if (is_file(public_path('build/manifest.json'))) {
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true) ?? [];
        }
        $cssEntry = $manifest['resources/css/app.css']['file'] ?? null;
        $jsEntry = $manifest['resources/js/app.js']['file'] ?? null;
    @endphp

    @if ($cssEntry)
        <link rel="stylesheet" href="{{ asset('build/'.$cssEntry) }}">
    @endif

    @if ($jsEntry)
        <script type="module" src="{{ asset('build/'.$jsEntry) }}"></script>
    @endif
@endif
