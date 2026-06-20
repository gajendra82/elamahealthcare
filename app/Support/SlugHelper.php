<?php

namespace App\Support;

use Illuminate\Support\Str;

class SlugHelper
{
    public const MAX_LENGTH = 512;

    public static function make(string $value, int $maxLength = self::MAX_LENGTH): string
    {
        $slug = Str::slug($value);

        if ($slug === '') {
            $slug = 'item';
        }

        return self::truncate($slug, $maxLength);
    }

    public static function unique(
        string $value,
        callable $exists,
        int $maxLength = self::MAX_LENGTH
    ): string {
        $base = self::make($value, $maxLength);
        $slug = $base;
        $counter = 1;

        while ($exists($slug)) {
            $suffix = '-'.$counter;
            $slug = self::truncate($base, $maxLength - strlen($suffix)).$suffix;
            $counter++;
        }

        return $slug;
    }

    private static function truncate(string $slug, int $maxLength): string
    {
        if ($maxLength < 1) {
            return 'item';
        }

        if (strlen($slug) <= $maxLength) {
            return $slug;
        }

        $slug = substr($slug, 0, $maxLength);

        return rtrim($slug, '-');
    }
}
