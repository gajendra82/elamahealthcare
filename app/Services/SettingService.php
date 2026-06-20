<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    private const CACHE_KEY = 'settings.flat';

    private const CACHE_TTL = 3600;

    public function __construct(
        private readonly SettingRepository $settingRepository
    ) {}

    public function all(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            $grouped = $this->settingRepository->all();

            return collect($grouped)->flatMap(fn ($items) => $items)->all();
        });
    }

    public function grouped(): array
    {
        return $this->settingRepository->all();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->all()[$key] ?? $this->settingRepository->get($key, $default);
    }

    public function set(string $key, mixed $value, string $group = 'general'): void
    {
        $this->settingRepository->set($key, $value, $group);
        $this->clearCache();
    }

    public function setMany(array $settings, string $group = 'general'): void
    {
        $this->settingRepository->setMany($settings, $group);
        $this->clearCache();
    }

    public function stats(): array
    {
        return [
            'years' => (int) $this->get('stat_years', 40),
            'countries' => (int) $this->get('stat_countries', 15),
            'products' => (int) $this->get('stat_products', 339),
            'partners' => (int) $this->get('stat_partners', 50),
            'manufacturing_partners' => (int) $this->get('stat_manufacturing_partners', 12),
        ];
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
        $this->settingRepository->clearCache();
    }
}
