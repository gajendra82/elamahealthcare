@props([
    'assets' => ['resources/css/app.css', 'resources/js/app.js'],
])

@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite($assets)
@else
    @php
        $cssFiles = glob(public_path('build/assets/app-*.css')) ?: [];
        $jsFiles = glob(public_path('build/assets/app-*.js')) ?: [];
    @endphp

    @foreach ($cssFiles as $cssFile)
        <link rel="stylesheet" href="{{ asset('build/assets/'.basename($cssFile)) }}">
    @endforeach

    @foreach ($jsFiles as $jsFile)
        <script type="module" src="{{ asset('build/assets/'.basename($jsFile)) }}"></script>
    @endforeach

    @if (empty($cssFiles) && empty($jsFiles) && app()->isProduction())
        <!-- Missing Vite build: run `npm run build` on your PC and upload the public/build/ folder -->
    @endif
@endif
