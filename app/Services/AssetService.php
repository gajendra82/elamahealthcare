<?php

namespace App\Services;

class AssetService
{
    public function url(?string $path, string $placeholder = 'default'): string
    {
        if ($path && $this->isAbsoluteUrl($path)) {
            return $path;
        }

        if ($path && $this->exists($path)) {
            return asset($this->normalize($path));
        }

        $fallback = config("assets.placeholders.{$placeholder}")
            ?? config('assets.placeholders.default');

        if ($fallback && $this->exists($fallback)) {
            return asset($this->normalize($fallback));
        }

        return asset($this->normalize($fallback ?? 'images/placeholders/default.svg'));
    }

    public function logoUrl(): string
    {
        $fromSettings = app(SettingService::class)->get('company_logo');

        return $this->url($fromSettings ?: config('assets.logo'), 'logo');
    }

    public function seoImageUrl(): string
    {
        $fromSettings = app(SettingService::class)->get('seo_default_image');

        return $this->url($fromSettings ?: config('assets.seo_image'), 'logo');
    }

    public function exists(?string $path): bool
    {
        if (! $path || $this->isAbsoluteUrl($path)) {
            return (bool) $path;
        }

        $path = $this->normalize($path);

        if (str_starts_with($path, 'storage/')) {
            $relative = substr($path, strlen('storage/'));

            return is_file(public_path($path))
                || is_file(storage_path('app/public/'.$relative));
        }

        return is_file(public_path($path));
    }

    public function normalize(string $path): string
    {
        return ltrim(str_replace('\\', '/', $path), '/');
    }

    public function isAbsoluteUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }

    /**
     * @return array<int, string>
     */
    public function configuredPaths(): array
    {
        $paths = [
            config('assets.logo'),
            config('assets.seo_image'),
            config('assets.about_preview'),
            config('assets.about_full'),
            ...array_column(config('assets.hero_banners', []), 'path'),
            ...array_values(config('assets.leadership', [])),
            ...config('assets.csr', []),
            ...config('assets.certificates', []),
            ...array_values(config('assets.placeholders', [])),
        ];

        return array_values(array_unique(array_filter($paths)));
    }
}
