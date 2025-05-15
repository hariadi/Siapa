<?php

namespace Hariadi\Siapa\Support;

class GenderGuesser
{
    public function guess(string $first, string $last, ?string $salutation = null): string
    {
        // check last name patterns & salutation
        foreach (SiapaLists::FEMALE_PATTERNS as $pattern) {
            if (str_contains(strtolower($last), $pattern) ||
                ($salutation && str_contains(strtolower($salutation), $pattern))) {
                return 'F';
            }
        }

        // check known female names from data file
        $femaleNames = file(__DIR__.'/../Data/female.txt', FILE_IGNORE_NEW_LINES);

        foreach ($femaleNames as $name) {
            if (str_contains($first, trim($name))) {
                return 'F';
            }
        }

        return 'M';
    }
}
