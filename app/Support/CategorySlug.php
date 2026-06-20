<?php

namespace App\Support;

use Illuminate\Support\Str;

class CategorySlug
{
    /**
     * Legacy navigation labels and aliases mapped to category slugs in the database.
     *
     * @var array<string, string>
     */
    private const ALIASES = [
        'injectables' => 'injection',
        'injectable' => 'injection',
        'injection' => 'injection',
        'tablets' => 'tablet',
        'tablet' => 'tablet',
        'capsules' => 'capsule',
        'capsule' => 'capsule',
        'ophthalmic' => 'drops',
        'eye-drops' => 'drops',
        'drops' => 'drops',
        'liquids' => 'liquid',
        'liquid' => 'liquid',
        'syrup' => 'syrup',
        'topical' => 'topical',
        'inhalation' => 'infusion',
    ];

    public static function resolve(?string $input): ?string
    {
        if ($input === null || $input === '' || $input === 'all') {
            return null;
        }

        $slug = Str::slug($input);

        return self::ALIASES[$slug] ?? $slug;
    }
}
