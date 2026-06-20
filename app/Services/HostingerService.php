<?php

namespace App\Services;

class HostingerService
{
    private ?bool $hostinger = null;

    public function isHostinger(): bool
    {
        if ($this->hostinger !== null) {
            return $this->hostinger;
        }

        if (env('SHARED_HOSTING') !== null) {
            return $this->hostinger = filter_var(env('SHARED_HOSTING'), FILTER_VALIDATE_BOOLEAN);
        }

        if (config('deployment.mode') === 'hostinger' && app()->environment('production')) {
            return $this->hostinger = true;
        }

        return $this->hostinger = $this->symlinkUnavailable() || $this->shellUnavailable();
    }

    public function symlinkUnavailable(): bool
    {
        if (! function_exists('symlink') || ! function_exists('link')) {
            return true;
        }

        return $this->isDisabled('symlink') || $this->isDisabled('link');
    }

    public function shellUnavailable(): bool
    {
        foreach (['exec', 'shell_exec', 'system'] as $function) {
            if ($this->isDisabled($function)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<int, string>
     */
    public function disabledFunctions(): array
    {
        $configured = config('deployment.disabled_functions', []);
        $disabled = array_filter(array_map('trim', explode(',', (string) ini_get('disable_functions'))));

        return array_values(array_unique(array_intersect($configured, $disabled)));
    }

    public function publicHtmlPath(): string
    {
        $configured = config('deployment.public_html');

        if (is_string($configured) && $configured !== '') {
            return $configured;
        }

        return dirname(base_path(), 2).DIRECTORY_SEPARATOR.'public_html';
    }

    public function laravelRelativeFromPublicHtml(): string
    {
        return str_replace('\\', '/', config('deployment.laravel_relative_from_public_html', '../laravel/elamahealthcare'));
    }

    public function uploadsPath(): string
    {
        return public_path(config('deployment.uploads', 'uploads'));
    }

    public function staticImagesPath(): string
    {
        return public_path(config('deployment.static_images', 'images'));
    }

    private function isDisabled(string $function): bool
    {
        if (! function_exists($function)) {
            return true;
        }

        $disabled = array_filter(array_map('trim', explode(',', (string) ini_get('disable_functions'))));

        return in_array($function, $disabled, true);
    }
}
