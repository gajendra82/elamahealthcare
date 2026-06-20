<?php

namespace App\Console\Commands;

use App\Models\Banner;
use App\Models\CsrGallery;
use App\Models\Leadership;
use App\Models\News;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Setting;
use App\Services\AssetService;
use App\Services\HostingerService;
use App\Services\StorageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ValidateAssetsCommand extends Command
{
    protected $signature = 'app:validate-assets';

    protected $description = 'Validate images, Vite build output, upload storage, and settings asset paths';

    public function handle(
        AssetService $assets,
        StorageService $storage,
        HostingerService $hostinger
    ): int {
        $this->info('Elama Healthcare — Asset Validation Report');
        $this->newLine();

        $issues = 0;

        $issues += $this->checkViteBuild();
        $issues += $this->checkUploadStorage($storage, $hostinger);
        $issues += $this->checkStaticDirectories($storage);
        $issues += $this->checkConfiguredAssets($assets);
        $issues += $this->checkDatabaseAssets($assets);
        $issues += $this->checkBladeReferences();

        $this->newLine();

        if ($issues === 0) {
            $this->info('All asset checks passed.');

            return self::SUCCESS;
        }

        $this->error("Found {$issues} issue(s). Review the report above.");

        return self::FAILURE;
    }

    private function checkViteBuild(): int
    {
        $this->line('<fg=cyan>Vite production build</>');

        $issues = 0;
        $manifest = public_path('build/manifest.json');

        if (! is_file($manifest)) {
            $this->error('  ✗ Missing public/build/manifest.json — run: npm run build');
            $issues++;
        } else {
            $this->info('  ✓ manifest.json exists');

            $assetsDir = public_path('build/assets');
            if (! is_dir($assetsDir) || count(glob($assetsDir.'/*')) === 0) {
                $this->error('  ✗ Missing public/build/assets/ files');
                $issues++;
            } else {
                $this->info('  ✓ build/assets/ populated');
            }
        }

        if (is_file(public_path('hot'))) {
            $this->warn('  ! public/hot exists — remove on production (Vite dev server marker)');
        }

        $this->newLine();

        return $issues;
    }

    private function checkUploadStorage(StorageService $storage, HostingerService $hostinger): int
    {
        $this->line('<fg=cyan>Upload storage</>');

        $issues = 0;

        if ($hostinger->isHostinger()) {
            $this->info('  ✓ Hostinger Shared Hosting detected');

            if ($hostinger->symlinkUnavailable()) {
                $this->info('  ✓ Symlink unavailable');
            }

            $storage->ensureUploadsDirectory();

            if (is_dir($storage->uploadsDirectory()) && is_writable($storage->uploadsDirectory())) {
                $this->info('  ✓ Upload directory exists');
            } else {
                $this->error('  ✗ public/uploads is missing or not writable');
                $issues++;
            }

            $this->info('  ✓ Using uploads directory');
            $this->info('  ✓ Storage fallback active');
        } else {
            if (is_dir(storage_path('app/public'))) {
                $this->info('  ✓ Local storage directory available');
            } else {
                $this->error('  ✗ storage/app/public missing');
                $issues++;
            }

            $storage->ensureUploadsDirectory();
            $this->info('  ✓ Storage fallback active');
        }

        $this->newLine();

        return $issues;
    }

    private function checkStaticDirectories(StorageService $storage): int
    {
        $this->line('<fg=cyan>Static assets</>');

        $issues = 0;
        $images = $storage->staticImagesDirectory();

        if (is_dir($images)) {
            $this->info('  ✓ images directory exists');
        } else {
            $this->error('  ✗ public/images missing');
            $issues++;
        }

        $this->newLine();

        return $issues;
    }

    private function checkConfiguredAssets(AssetService $assets): int
    {
        $this->line('<fg=cyan>Configured asset paths (config/assets.php)</>');

        $issues = 0;

        foreach ($assets->configuredPaths() as $path) {
            if ($assets->exists($path)) {
                $this->info("  ✓ {$path}");
            } else {
                $this->error("  ✗ Missing: {$path}");
                $issues++;
            }
        }

        $this->newLine();

        return $issues;
    }

    private function checkDatabaseAssets(AssetService $assets): int
    {
        $this->line('<fg=cyan>Database image references</>');

        $issues = 0;

        $checks = [
            'settings.company_logo' => Setting::query()->where('key', 'company_logo')->value('value'),
            'settings.seo_default_image' => Setting::query()->where('key', 'seo_default_image')->value('value'),
        ];

        foreach (Product::query()->whereNotNull('image')->pluck('image', 'id') as $id => $path) {
            $checks["products.{$id}"] = $path;
        }

        foreach (Banner::query()->pluck('image', 'id') as $id => $path) {
            $checks["banners.{$id}"] = $path;
        }

        foreach (Leadership::query()->whereNotNull('photo')->pluck('photo', 'id') as $id => $path) {
            $checks["leadership.{$id}"] = $path;
        }

        foreach (News::query()->whereNotNull('image')->pluck('image', 'id') as $id => $path) {
            $checks["news.{$id}"] = $path;
        }

        foreach (CsrGallery::query()->pluck('image', 'id') as $id => $path) {
            $checks["csr.{$id}"] = $path;
        }

        foreach (Partner::query()->whereNotNull('logo')->pluck('logo', 'id') as $id => $path) {
            $checks["partners.{$id}"] = $path;
        }

        foreach ($checks as $label => $path) {
            if (! $path) {
                continue;
            }

            if ($assets->exists($path)) {
                $this->info("  ✓ {$label}: {$path}");
            } else {
                $this->error("  ✗ {$label}: {$path}");
                $issues++;
            }
        }

        $this->newLine();

        return $issues;
    }

    private function checkBladeReferences(): int
    {
        $this->line('<fg=cyan>Blade hardcoded image paths</>');

        $issues = 0;
        $patterns = [
            'images/hero/' => 'Use images/banners/ or $banners from database',
            'logo.png' => 'Use images/logo/logo.jpeg or <x-logo />',
            'images/about/about-' => 'Use config("assets.about_*") or asset_url()',
            'images/csr/csr-' => 'Use CsrGallery model or config("assets.csr")',
            'images/products/default.jpg' => 'Use asset_url() with product placeholder',
            'public/storage' => 'Use public/uploads on shared hosting',
        ];

        $files = File::allFiles(resource_path('views'));

        foreach ($files as $file) {
            $contents = $file->getContents();
            $relative = str_replace(base_path(DIRECTORY_SEPARATOR), '', $file->getPathname());

            foreach ($patterns as $needle => $hint) {
                if (str_contains($contents, $needle)) {
                    $this->error("  ✗ {$relative} references \"{$needle}\" — {$hint}");
                    $issues++;
                }
            }
        }

        if ($issues === 0) {
            $this->info('  ✓ No known invalid hardcoded paths in Blade views');
        }

        $this->newLine();

        return $issues;
    }
}
