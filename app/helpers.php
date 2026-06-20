<?php

use App\Services\AssetService;

if (! function_exists('asset_url')) {
    function asset_url(?string $path, string $placeholder = 'default'): string
    {
        return app(AssetService::class)->url($path, $placeholder);
    }
}

if (! function_exists('asset_exists')) {
    function asset_exists(?string $path): bool
    {
        return app(AssetService::class)->exists($path);
    }
}
