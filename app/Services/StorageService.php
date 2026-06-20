<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    private const UPLOADS_DISK = 'uploads';

    private const LOCAL_DISK = 'public';

    private const UPLOADS_PUBLIC_DIR = 'uploads';

    private ?bool $sharedHosting = null;

    public function isSharedHosting(): bool
    {
        if ($this->sharedHosting !== null) {
            return $this->sharedHosting;
        }

        if (env('SHARED_HOSTING') !== null) {
            return $this->sharedHosting = filter_var(env('SHARED_HOSTING'), FILTER_VALIDATE_BOOLEAN);
        }

        $disabled = array_filter(array_map('trim', explode(',', (string) ini_get('disable_functions'))));

        return $this->sharedHosting = in_array('symlink', $disabled, true)
            || in_array('link', $disabled, true);
    }

    public function diskName(): string
    {
        return $this->isSharedHosting() ? self::UPLOADS_DISK : self::LOCAL_DISK;
    }

    public function disk(): Filesystem
    {
        return Storage::disk($this->diskName());
    }

    public function publicUrlPrefix(): string
    {
        return $this->isSharedHosting() ? self::UPLOADS_PUBLIC_DIR : 'storage';
    }

    public function uploadsDirectory(): string
    {
        return public_path(self::UPLOADS_PUBLIC_DIR);
    }

    public function ensureUploadsDirectory(): void
    {
        if (! is_dir($this->uploadsDirectory())) {
            mkdir($this->uploadsDirectory(), 0755, true);
        }
    }

    public function store(UploadedFile $file, string $directory): string
    {
        if ($this->isSharedHosting()) {
            $this->ensureUploadsDirectory();
        }

        return $file->store($directory, $this->diskName());
    }

    public function delete(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        $path = $this->normalizeStoredPath($path);
        $deleted = false;

        if ($this->disk()->exists($path)) {
            $deleted = $this->disk()->delete($path);
        }

        foreach ($this->resolvePhysicalPaths($path) as $physical) {
            if (is_file($physical) && @unlink($physical)) {
                $deleted = true;
            }
        }

        return $deleted;
    }

    public function exists(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        $path = $this->normalizeStoredPath($path);

        if (str_starts_with($path, 'images/')) {
            return is_file(public_path($path));
        }

        foreach ($this->resolvePhysicalPaths($path) as $physical) {
            if (is_file($physical)) {
                return true;
            }
        }

        return $this->disk()->exists($path);
    }

    public function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $normalized = $this->normalizeStoredPath($path);

        if (str_starts_with($normalized, 'images/')) {
            return asset($normalized);
        }

        if (is_file(public_path(self::UPLOADS_PUBLIC_DIR.'/'.$normalized))) {
            return asset(self::UPLOADS_PUBLIC_DIR.'/'.$normalized);
        }

        if (is_file(public_path($normalized))) {
            return asset($normalized);
        }

        if (is_file(storage_path('app/public/'.$normalized))) {
            return asset($this->publicUrlPrefix().'/'.$normalized);
        }

        return asset($this->publicUrlPrefix().'/'.$normalized);
    }

    public function physicalPath(string $path): ?string
    {
        foreach ($this->resolvePhysicalPaths($this->normalizeStoredPath($path)) as $physical) {
            if (is_file($physical)) {
                return $physical;
            }
        }

        return null;
    }

    public function normalizeStoredPath(string $path): string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }

        if (str_starts_with($path, 'uploads/')) {
            $path = substr($path, strlen('uploads/'));
        }

        return $path;
    }

    /**
     * @return array<int, string>
     */
    public function resolvePhysicalPaths(string $path): array
    {
        $path = $this->normalizeStoredPath($path);

        if (str_starts_with($path, 'images/')) {
            return [public_path($path)];
        }

        return array_values(array_unique([
            public_path(self::UPLOADS_PUBLIC_DIR.'/'.$path),
            storage_path('app/public/'.$path),
            public_path('storage/'.$path),
            public_path($path),
        ]));
    }
}
