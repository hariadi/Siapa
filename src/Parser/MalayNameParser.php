<?php

namespace Hariadi\Siapa\Parser;

use Hariadi\Siapa\Data\NameParts;
use Hariadi\Siapa\Support\GenderGuesser;
use Hariadi\Siapa\Support\Helpers;

class MalayNameParser
{
    public function parse(string $raw): NameParts
    {
        $normalized = Helpers::normalizeName($raw);
        $salutation = Helpers::extractSalutation($normalized);
        $body = Helpers::stripSalutation($normalized, $salutation);
        $words = array_values(array_filter(explode(' ', ucwords($body))));
        $first = $last = '';
        $i = 0;

        // build first name until hitting a middle
        while ($i < count($words) - 1 && ! Helpers::isMiddle($words[$i])) {
            $first .= ' '.Helpers::fixCase($words[$i++]);
        }

        // rest is last name
        while ($i < count($words)) {
            $word = $words[$i++];

            if (! Helpers::isMiddle($word) && ! Helpers::isFemalePattern($word)) {
                $last .= ' '.Helpers::fixCase($word);
            }
        }

        $first = trim($first);
        $last = trim($last);

        $gender = (new GenderGuesser())->guess($first, $last, $salutation);

        return new NameParts($salutation, $first, $last, $gender);
    }
}
