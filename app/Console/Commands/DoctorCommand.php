<?php

namespace App\Console\Commands;

use App\Services\HostingerService;
use App\Services\StorageService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class DoctorCommand extends Command
{
    protected $signature = 'app:doctor {--deploy : Run post-deployment validation checks}';

    protected $description = 'Diagnose production readiness for Hostinger shared hosting';

    private int $errors = 0;

    private int $warnings = 0;

    public function handle(HostingerService $hostinger, StorageService $storage): int
    {
        $this->info('Elama Healthcare — Deployment Doctor');
        $this->newLine();

        $this->section('Environment');
        $this->checkPhpVersion();
        $this->checkExtensions();
        $this->checkAppKey();
        $this->checkEnvironment();
        $this->checkDisabledFunctions($hostinger);

        $this->section('Database & Services');
        $this->checkDatabase();
        $this->checkSessions();
        $this->checkCache();

        $this->section('Storage & Assets');
        $this->checkHostinger($hostinger, $storage);
        $this->checkWritablePaths();
        $this->checkViteManifest();
        $this->checkPublicAssets($storage);

        $this->section('Application');
        $this->checkVendor();
        $this->checkBootstrap();

        if ($this->option('deploy')) {
            $this->section('Deployment');
            $this->checkPublicHtml($hostinger);
        }

        $this->newLine();
        $this->line("Summary: {$this->errors} error(s), {$this->warnings} warning(s)");

        if ($this->errors > 0) {
            $this->error('Doctor found blocking issues.');

            return self::FAILURE;
        }

        $this->info('All critical checks passed.');

        return self::SUCCESS;
    }

    private function section(string $title): void
    {
        $this->newLine();
        $this->line("<fg=cyan>{$title}</>");
    }

    private function ok(string $message): void
    {
        $this->info("  ✓ {$message}");
    }

    private function recordWarning(string $message): void
    {
        $this->warnings++;
        parent::warn("  ! {$message}");
    }

    private function recordError(string $message): void
    {
        $this->errors++;
        $this->error("  ✗ {$message}");
    }

    private function checkPhpVersion(): void
    {
        $required = config('deployment.php_version', '8.2.0');

        if (version_compare(PHP_VERSION, $required, '>=')) {
            $this->ok('PHP '.PHP_VERSION);
        } else {
            $this->recordError("PHP {$required}+ required, found ".PHP_VERSION);
        }
    }

    private function checkExtensions(): void
    {
        foreach (config('deployment.required_extensions', []) as $extension) {
            if (extension_loaded($extension)) {
                $this->ok("Extension {$extension}");
            } else {
                $this->recordError("Missing PHP extension: {$extension}");
            }
        }
    }

    private function checkAppKey(): void
    {
        $key = config('app.key');

        if ($key && $key !== 'base64:') {
            $this->ok('APP_KEY configured');
        } else {
            $this->recordError('APP_KEY is missing — run: php artisan key:generate');
        }
    }

    private function checkEnvironment(): void
    {
        if (is_file(base_path('.env'))) {
            $this->ok('.env file loaded');
        } else {
            $this->recordError('.env file missing');
        }

        if (config('app.url')) {
            $this->ok('APP_URL: '.config('app.url'));
        } else {
            $this->recordWarning('APP_URL is empty');
        }

        if (config('app.debug') && config('app.env') === 'production') {
            $this->recordWarning('APP_DEBUG is enabled in production');
        } else {
            $this->ok('Debug mode acceptable for environment');
        }
    }

    private function checkDisabledFunctions(HostingerService $hostinger): void
    {
        $disabled = $hostinger->disabledFunctions();

        if ($disabled !== []) {
            $this->ok('Hostinger restrictions detected: '.implode(', ', $disabled));
        } else {
            $this->ok('No Hostinger function restrictions detected');
        }
    }

    private function checkDatabase(): void
    {
        try {
            DB::connection()->getPdo();
            $this->ok('Database connection successful');
        } catch (Throwable $exception) {
            $this->recordError('Database connection failed: '.$exception->getMessage());
        }
    }

    private function checkSessions(): void
    {
        $driver = config('session.driver');

        if ($driver === 'file') {
            $this->ok('SESSION_DRIVER=file (no sessions table required)');
        } elseif ($driver === 'database') {
            $this->recordWarning('SESSION_DRIVER=database — ensure sessions table exists');
        } else {
            $this->ok("SESSION_DRIVER={$driver}");
        }
    }

    private function checkCache(): void
    {
        $store = config('cache.default');

        if ($store === 'file') {
            $this->ok('CACHE_STORE=file (no cache table required)');
        } elseif ($store === 'database') {
            $this->recordWarning('CACHE_STORE=database — ensure cache table exists');
        } else {
            $this->ok("CACHE_STORE={$store}");
        }
    }

    private function checkHostinger(HostingerService $hostinger, StorageService $storage): void
    {
        if ($hostinger->isHostinger()) {
            $this->ok('Hostinger Shared Hosting detected');
        }

        if ($hostinger->symlinkUnavailable()) {
            $this->ok('Symlink unavailable — public/storage not required');
        }

        $storage->ensureUploadsDirectory();

        if (is_dir($storage->uploadsDirectory()) && is_writable($storage->uploadsDirectory())) {
            $this->ok('public/uploads available');
        } else {
            $this->recordError('public/uploads missing or not writable');
        }

        if (file_exists(public_path('storage'))) {
            $this->recordWarning('public/storage exists but is not required on Hostinger');
        } else {
            $this->ok('No dependency on public/storage symlink');
        }
    }

    private function checkWritablePaths(): void
    {
        foreach (config('deployment.writable_paths', []) as $relative) {
            $path = base_path($relative);

            if (is_dir($path) && is_writable($path)) {
                $this->ok("Writable: {$relative}");
            } else {
                $this->recordError("Not writable: {$relative}");
            }
        }
    }

    private function checkViteManifest(): void
    {
        $manifest = public_path('build/manifest.json');

        if (is_file($manifest)) {
            $this->ok('Vite manifest exists');
        } else {
            $this->recordError('Missing public/build/manifest.json — run: npm run build');
        }
    }

    private function checkPublicAssets(StorageService $storage): void
    {
        if (is_dir($storage->staticImagesDirectory())) {
            $this->ok('Static images directory exists');
        } else {
            $this->recordError('public/images missing');
        }

        if (is_dir(public_path('build'))) {
            $this->ok('public/build exists');
        } else {
            $this->recordError('public/build missing');
        }
    }

    private function checkVendor(): void
    {
        if (is_file(base_path('vendor/autoload.php'))) {
            $this->ok('Vendor autoload available');
        } else {
            $this->recordError('Vendor missing — run: composer install');
        }
    }

    private function checkBootstrap(): void
    {
        if (is_file(base_path('bootstrap/app.php'))) {
            $this->ok('Laravel bootstrap available');
        } else {
            $this->recordError('bootstrap/app.php missing');
        }
    }

    private function checkPublicHtml(HostingerService $hostinger): void
    {
        $publicHtml = $hostinger->publicHtmlPath();

        if (! is_dir($publicHtml)) {
            $this->recordError("public_html not found at {$publicHtml}");

            return;
        }

        $this->ok("public_html found: {$publicHtml}");

        $index = $publicHtml.DIRECTORY_SEPARATOR.'index.php';
        if (is_file($index)) {
            $this->ok('public_html/index.php exists');
        } else {
            $this->recordError('public_html/index.php missing');
        }

        foreach (['build/manifest.json', 'images', 'uploads'] as $relative) {
            $path = $publicHtml.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relative);

            if (str_ends_with($relative, 'manifest.json') ? is_file($path) : is_dir($path)) {
                $this->ok("public_html/{$relative} exists");
            } else {
                $this->recordError("public_html/{$relative} missing");
            }
        }

        $htaccess = $publicHtml.DIRECTORY_SEPARATOR.'.htaccess';
        if (is_file($htaccess)) {
            $this->ok('public_html/.htaccess exists');
        } else {
            $this->recordError('public_html/.htaccess missing');
        }

        $relative = $hostinger->laravelRelativeFromPublicHtml();
        $vendor = $publicHtml.DIRECTORY_SEPARATOR.$relative.'/vendor/autoload.php';
        $vendor = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $vendor);

        if (is_file($vendor)) {
            $this->ok('Laravel vendor reachable from public_html');
        } else {
            $this->recordError('Laravel vendor not reachable from public_html/index.php path');
        }

        if (config('app.url')) {
            try {
                $response = @file_get_contents(rtrim(config('app.url'), '/').'/');
                if ($response !== false) {
                    $this->ok('Homepage HTTP check passed');
                } else {
                    $this->recordWarning('Could not verify homepage HTTP 200 from server');
                }
            } catch (Throwable) {
                $this->recordWarning('Could not verify homepage HTTP 200 from server');
            }
        }
    }
}
