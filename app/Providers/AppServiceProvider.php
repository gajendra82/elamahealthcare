<?php

namespace App\Providers;

use App\Services\AssetService;
use App\Services\SettingService;
use App\Services\StorageService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(StorageService::class);
        $this->app->singleton(AssetService::class);
    }

    public function boot(): void
    {
        $storage = app(StorageService::class);

        if ($storage->isSharedHosting()) {
            $storage->ensureUploadsDirectory();
        }

        View::composer('*', function ($view) use ($storage) {
            $view->with('settings', app(SettingService::class)->all());
            $view->with('settingsGrouped', app(SettingService::class)->grouped());
            $view->with('assetService', app(AssetService::class));
            $view->with('storageUrlPrefix', $storage->publicUrlPrefix());
        });
    }
}
