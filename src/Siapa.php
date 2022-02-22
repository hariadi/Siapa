<?php

namespace Hariadi\Siapa;

class Siapa
{
    protected array $salutations = [
        'tun',
        'toh puan',
        'tan sri dato\'',
        'tan sri haji',
        'tan sri hj.',
        'tan sri',
        'puan sri',
        'dato\' sri',
        'dato\' seri',
        'datuk seri',
        'datuk dr. ir.',
        'datuk dr ir.',
        'datuk dr. ir',
        'datuk dr ir',
        'datuk dr',
        'datuk',
        'datin dr. ir.',
        'datin dr. ir',
        'datin dr ir.',
        'datin dr ir',
        'datin dr.',
        'datin dr',
        'dato\' dr ir haji',
        'dato\' dr. ir. haji',
        'dato\' dr ir. haji',
        'dato\' dr. ir haji',
        'dato\' dr ir hj.',
        'dato\' dr. ir. hj.',
        'dato\' dr ir. hj.',
        'dato\' dr. ir hj.',
        'dato\' dr.',
        'dato\'',
        'datin',
        'encik',
        'puan',
        'cik',
        'en.',
        'pn.',
        'ir.',
        'dr.',
    ];

    protected array $middles = [
        'von',
        'binti',
        'mohamad',
        'mohd.',
        'syed', 'bte',
        'bt.',
        'bin',
        'bt',
        'a/l',
        'a/p',
    ];

    protected array $patronym = [
        'binti',
        'bte',
        'bt.',
        'bin',
        'bt',
        'a/l',
        'a/p',
    ];

    protected array $female = [
        'Binti ',
        'Bte. ',
        'Bte ',
        'Puan ',
        'Puan ',
        'Pn. ',
        'Bt. ',
        'Bt ',
        'A/P ',
    ];

    protected $name;

    protected $salutation;

    protected $first;

    protected $last;

    protected $encoding;

    /**
     * Initializes Siapa object and assigns both name and encoding properties
     * the supplied values. $name is cast to a string prior to assignment, and
     * if $encoding is not specified, it defaults to mb_internal_encoding().
     * Throws an InvalidArgumentException if the first argument is an array or
     * object without a __toString method.
     *
     * @param  mixed  $name     Value to modify, after being cast to string
     * @param  string $encoding The character encoding
     * @throws \InvalidArgumentException if an array or object without a
     * __toString method is passed as the first argument
     */
    public function __construct($name, $encoding = null)
    {
        if (is_array($name)) {
            throw new \InvalidArgumentException(
                'Passed value cannot be an array'
            );
        } elseif (is_object($name) && ! method_exists($name, '__toString')) {
            throw new \InvalidArgumentException(
                'Passed object must have a __toString method'
            );
        }
        $this->name = (string) $name;
        $this->encoding = $encoding ?: mb_internal_encoding();
        $this->parser();
    }

    /**
     * Initializes Siapa object and assigns both name and encoding properties
     * the supplied values. $name is cast to a string prior to assignment, and
     * if $encoding is not specified, it defaults to mb_internal_encoding().
     * Throws an InvalidArgumentException if the first argument is an array or
     * object without a __toString method.
     *
     * @param  mixed  $name     Value to modify, after being cast to string
     * @param  string $encoding The character encoding
     * @throws \InvalidArgumentException if an array or object without a
     * __toString method is passed as the first argument
     */
    public static function name($name, $encoding = null)
    {
        return new static($name, $encoding);
    }

    /**
     * Returns the value in $name.
     *
     * @return string The current value of the $name property
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Adds an element at the end of the salutation collection.
     *
     * @param mixed $salute The element to add.
     *
     * @return array.
     */
    public function setSalutation($salute)
    {
        return $this->addSalutation($salute);
    }

    /**
     * Adds an element at the end of the middle collection.
     *
     * @param mixed $middle The element to add.
     *
     * @return array.
     */
    public function setMiddle($middle)
    {
        return $this->addMiddle($middle);
    }

    /**
     * Returns the encoding used by the Siapa object.
     *
     * @return string The current value of the $encoding property
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Gets all values of the female name collection.
     *
     * @return array The values of all female name in the collection
     */
    public function getFemaleNames()
    {
        return file(__DIR__.'/data/female.txt');
    }

    /**
     * Returns the value in $name. The name always include their middle.
     *
     * @return string The current value of the $name property
     */
    public function nama()
    {
        return self::givenName();
    }

    /**
     * Returns the value in $name with or without middle.
     *
     * @param bool $middle
     *
     * @return string The current value of the $name property
     */
    public function givenName(bool $middle = false): string
    {
        $givenName = $this->first.' '.$this->last;

        if (! $middle) {
            foreach ($this->patronym as $mid) {
                $givenName = str_replace(ucfirst($mid).' ', '', $givenName);
            }
        } else {
            foreach ($this->patronym as $mid) {
                $givenName = str_replace(ucfirst($mid), $mid, $givenName);
            }
        }

        return htmlspecialchars_decode(trim($givenName), ENT_QUOTES);
    }

    /**
     * Get the salutation from full name.
     *
     * @return ?string The current value of the $salutation property
     */
    public function salutation(): ?string
    {
        if (is_null($this->salutation)) {
            return null;
        }

        return htmlspecialchars_decode($this->salutation, ENT_QUOTES);
    }

    /**
     * Get the first name from full name.
     *
     * @return string The current value of the $first property
     */
    public function first(): string
    {
        return htmlspecialchars_decode($this->first, ENT_QUOTES);
    }

    /**
     * Get the last name from full name.
     *
     * @return string The current value of the $last property
     */
    public function last(): string
    {
        return htmlspecialchars_decode($this->last, ENT_QUOTES);
    }

    /**
     * Get the gender from full name. Gender are check from their middle name,
     * salutation and collection of female name.
     *
     * @param bool $short F for Female and M for Male
     *
     * @return string
     */
    public function gender(bool $short = true): string
    {
        $gender = 'Male';

        // check for last name
        foreach ($this->female as $female) {
            if (strpos($this->last, $female) !== false) {
                $gender = 'Female';

                break;
            }
        }

        // check in salutation
        if ($gender != 'Female') {
            foreach (['Hajah', 'Hajjah', 'Hjh.', 'Puan', 'Pn.', 'Cik'] as $female) {
                if ($this->salutation && str_contains($this->salutation, $female)) {
                    $gender = 'Female';

                    break;
                }
            }
        }

        // then we check female common name
        if ($gender != 'Female') {
            foreach (self::getFemaleNames() as $female) {
                if (str_contains($this->first, $female)) {
                    $gender = 'Female';

                    break;
                }
            }
        }

        if (! $short) {
            return $gender;
        }

        return $gender[0];
    }

    /**
     * Returns the length of the name.
     *
     * @return int The number of characters in the name
     */
    public function count()
    {
        return $this->length();
    }

    /**
     * Returns the length of the name. An alias for PHP's mb_strlen() function.
     *
     * @return int The number of characters in $name given the encoding
     */
    public function length(): int
    {
        return mb_strlen($this->name, $this->encoding);
    }

    /**
     * Parsing complex Malay names into their individual components.
     */
    protected function parser()
    {
        $full_name = $this->name;

        $full_name = trim(str_replace('  ', ' ', $full_name));
        $full_name = htmlspecialchars_decode(htmlspecialchars($full_name, ENT_QUOTES));

        //before explode, we need to extract salutation
        $full_name = strtolower($full_name);

        foreach ($this->salutations as $salute) {
            // salutation must start from position 0
            // if salutation found but start from > 0 then that they father salutation
            if (str_contains($full_name, $salute) && str_starts_with($full_name, $salute)) {
                $this->salutation = $this->fixCase($salute);
                $full_name = str_replace($salute, '', $full_name);
            }
        }

        $full_name = str_replace('  ', ' ', $full_name);
        $full_name = ucwords(strtolower(trim($full_name)));

        // split into words
        $unfiltered_name_parts = explode(' ', $full_name);
        $name_parts = [];

        // completely ignore any words in parentheses
        foreach ($unfiltered_name_parts as $word) {
            if ($word[0] != '(') {
                $name_parts[] = $word;
            }
        }

        $num_words = count($name_parts);

        $start = 0;
        $end = $num_words;

        // concat the first name
        for ($i = $start; $i < $end - 1; $i++) {
            $word = $name_parts[$i];

            // move on to parsing the last name if we find an indicator of a compound last name (Binti, Bin, , Bte, Mohd, Syed etc)
            // we use $i != $start to allow for rare cases where an indicator is actually the first name (like "Syed Cromok")
            if ($this->isMiddle($word) && $i != $start) {
                break;
            }
            // is it a middle initial or part of their first name?
            // if we start off with an initial, we'll call it the first name
            $this->first .= ' '.$this->fixCase($word);
        }

        // check that we have more than 1 word in our string

        if ($end - $start > 1) {
            // concat the last name
            for ($i; $i < $end; $i++) {
                $this->last .= ' '.$this->fixCase($name_parts[$i]);
            }
        } else {
            // otherwise, single word strings are assumed to be first names
            $this->first = $this->fixCase($name_parts[$i]);
        }

        $this->first = trim($this->first);
        $this->last = trim($this->last);
    }

    /**
     * Adds a salutation element at the end of the collection.
     *
     * @param mixed $salute The salutation to add.
     */
    protected function addSalutation($salute)
    {
        if (is_array($salute)) {
            foreach ($salute as $tabik) {
                $this->salutations[] = htmlspecialchars($tabik, ENT_QUOTES);
            }
        } else {
            $this->salutations[] = htmlspecialchars($salute, ENT_QUOTES);
        }
    }

    /**
     * Adds a middle element at the end of the collection.
     *
     * @param mixed $middle The middle to add.
     */
    protected function addMiddle($middle)
    {
        if (is_array($middle)) {
            foreach ($middle as $mid) {
                $this->middles[] = $mid;
            }
        } else {
            $this->middles[] = $middle;
        }
    }

    /**
     * Check if middle exist in name.
     *
     * @param string $word The middle to check.
     *
     * @return string middle name.
     */
    protected function isMiddle($word): string
    {
        $word = strtolower($word);

        return array_search($word, $this->middles);
    }

    /**
     * Detect mixed case words.
     *
     * @param string $word The word to check.
     *
     * @return bool
     */
    protected function isCamelcase($word): bool
    {
        if (preg_match('|[A-Z]+|s', $word) && preg_match('|[a-z]+|s', $word)) {
            return true;
        }

        return false;
    }

    /**
     * Normalize words. ucfirst words split by dashes or periods.
     * ucfirst all upper/lower strings, but leave camelcase words alone.
     *
     * @param string $word The word to normalize.
     *
     * @return string
     */
    protected function fixCase($word): string
    {
        // uppercase words split by dashes, like "Kimura-Fay"
        $word = $this->safeUcfirst('-', $word);
        // uppercase words split by periods, like "J.P."
        $word = $this->safeUcfirst('.', $word);
        $word = $this->safeUcfirst(' ', $word);
        $word = $this->safeUcfirst('@', $word);
        $word = $this->safeUcfirst('/', $word);

        return $word;
    }

    /**
     * helper public function for fixCase.
     *
     * @param string $separator The separator.
     * @param string $word      The word to check.
     */
    public function safeUcfirst($separator, $word): string
    {
        // uppercase words split by the separator (ex. dashes or periods)
        $parts = explode($separator, $word);

        foreach ($parts as $word) {
            $words[] = ($this->isCamelcase($word)) ? $word : ucfirst(strtolower($word));
        }

        return implode($separator, $words);
    }
}
