<?php

namespace App\Support;

class GlobalPresence
{
    /**
     * @return array<string, array{code: string, name: string, region: string, type: string}>
     */
    public static function countriesByCode(): array
    {
        $countries = [];

        $hq = config('global_presence.headquarters');
        if ($hq) {
            $countries[$hq['code']] = $hq;
        }

        foreach (config('global_presence.markets', []) as $market) {
            $countries[$market['code']] = $market;
        }

        return $countries;
    }

    /**
     * @return array<int, array{code: string, name: string, region: string, type: string}>
     */
    public static function allCountries(): array
    {
        return array_values(self::countriesByCode());
    }

    /**
     * @return array<int, string>
     */
    public static function regionCodes(): array
    {
        return array_keys(self::countriesByCode());
    }
}
