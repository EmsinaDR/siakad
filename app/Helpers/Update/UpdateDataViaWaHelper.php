<?php

/*
    |----------------------------------------------------------------------
    | 📌 Helper UpdateDataViaWaHelper
    |----------------------------------------------------------------------
    |
*/

if (!function_exists('ArrayUpdateDataWa')) {
    /**
     * Assign key:value strings from array to a Laravel model or any object
     *
     * @param array $parts Array of strings like "key:value"
     * @param \Illuminate\Database\Eloquent\Model|object $model Target model atau object
     * @param int $skip Awal array yang ingin dilewati
     * @return void
     */
    function ArrayUpdateDataWa(array $parts, object $model, int $skip = 0): void
    {
        // Skip bagian awal jika diminta
        $parts = array_slice($parts, $skip);

        foreach ($parts as $part) {
            if (str_contains($part, ':')) {
                [$key, $value] = explode(':', $part, 2);
                $value = trim($value);
                if ($value !== '') {
                    $model->{$key} = $value;
                }
            }
        }
    }
}
