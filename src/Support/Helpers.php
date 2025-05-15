<?php

namespace Hariadi\Siapa\Support;

class Helpers
{
    public static function normalizeName(string $name): string
    {
        return strtolower(preg_replace('/\s+/', ' ', trim(htmlspecialchars_decode(htmlspecialchars($name, ENT_QUOTES), ENT_QUOTES))));
    }

    public static function extractSalutation(string $name): ?string
    {
        foreach (SiapaLists::SALUTATIONS as $salute) {
            if (str_starts_with($name, $salute)) {
                return self::fixCase($salute);
            }
        }

        return null;
    }

    public static function stripSalutation(string $name, ?string $salutation): string
    {
        if (! $salutation) {
            return $name;
        }

        return trim(substr($name, strlen(strtolower($salutation))));
    }

    public static function isMiddle(string $word): bool
    {
        return in_array(strtolower($word), SiapaLists::MIDDLES, true);
    }

    public static function fixCase(string $word): string
    {
        // normalize dashed or spaced words
        foreach (['-', ' '] as $sep) {
            $parts = explode($sep, $word);
            $parts = array_map(fn ($p) => ctype_upper($p[0]) && ctype_lower(substr($p, 1)) ? $p : ucfirst(strtolower($p)), $parts);
            $word = implode($sep, $parts);
        }

        return $word;
    }

    public static function isFemalePattern(string $word): bool
    {
        return in_array(strtolower($word), SiapaLists::FEMALE_PATTERNS, true);
    }
}
