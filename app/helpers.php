<?php

use App\Services\AssetService;
use App\Services\StorageService;

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

if (! function_exists('storage_url')) {
    function storage_url(?string $path): ?string
    {
        return app(StorageService::class)->url($path);
    }
}
