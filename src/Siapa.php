<?php

namespace Hariadi;

class Siapa
{
    private $salutations = array(
        'tun',
        'toh puan',
        'tan sri dato&#039;',
        'tan sri haji',
        'tan sri hj.',
        'tan sri',
        'puan sri',
        'dato&#039; sri',
        'dato&#039; seri',
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
        'dato&#039; dr ir haji',
        'dato&#039; dr. ir. haji',
        'dato&#039; dr ir. haji',
        'dato&#039; dr. ir haji',
        'dato&#039; dr ir hj.',
        'dato&#039; dr. ir. hj.',
        'dato&#039; dr ir. hj.',
        'dato&#039; dr. ir hj.',
        'dato&#039; dr.',
        'dato&#039;',
        'datin',
        'encik',
        'puan',
        'cik',
        'en.',
        'pn.',
        'ir.',
        'dr.'
    );

    private $middles = array(
        'von',
        'binti',
        'mohamad',
        'mohd.',
        'syed', 'bte',
        'bt.',
        'bin',
        'bt',
        'a/l',
        'a/p'
    );

    private $female = array('Binti ', 'Bte. ', 'Bte ', 'Puan ', 'Puan ', 'Pn. ', 'Bt. ', 'Bt ', 'A/P ');

    private $salutation;
    private $first;
    private $last;

    public function __construct($name, $encoding = null)
    {
        if (is_array($name)) {
            throw new \InvalidArgumentException(
                'Passed value cannot be an array'
                );
        } else if (is_object($name) && !method_exists($name, '__toString')) {
            throw new \InvalidArgumentException(
                'Passed object must have a __toString method'
                );
        }
        $this->name = (string) $name;
        $this->encoding = $encoding ?: mb_internal_encoding();
        $this->parser();
    }

    public static function name($name, $encoding = null)
    {
        return new static($name, $encoding);
    }

    public function __toString()
    {
        return $this->name;
    }

    public function setSalutation($salute)
    {
        return $this->addSalutation($salute);
    }

    public function setMiddle($middle)
    {
        return $this->addMiddle($middle);
    }

    public function getEncoding()
    {
        return $this->encoding;
    }

    public function getFemaleNames()
    {
        return file( __DIR__ . '/data/female.txt');
    }

    public function nama()
    {
        return self::givenName();
    }

    public function givenName($middle = false)
    {
        $givenName = $this->name;
        if (!$middle) {
            foreach ($this->middles as $mid) {
                $givenName = str_replace($mid, '', $givenName);
            }
        }
        return htmlspecialchars_decode(trim($givenName));
    }

    public function salutation()
    {
        return htmlspecialchars_decode($this->salutation);
    }

    public function first()
    {
        return htmlspecialchars_decode($this->first);
    }

    public function last()
    {
        return htmlspecialchars_decode($this->last);
    }

    public function gender($short = true)
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
            foreach (array('Hajah', 'Hajjah', 'Hjh.', 'Puan', 'Pn.', 'Cik') as $female) {
                if (strpos($this->salutation, $female) !== false) {
                    $gender = 'Female';
                    break;
                }
            }
        }

        // then we check female common name
        if ($gender != 'Female') {
            foreach (self::getFemaleNames() as $female) {
                if (strpos($this->first, $female) !== false) {
                    $gender = 'Female';
                    break;
                }
            }
        } 
        return ($short) ? $gender{0} : $gender;
    }

    public function count()
    {
        return $this->length();
    }

    /**
    * Returns the length of the name. An alias for PHP's mb_strlen() function.
    *
    * @return int The number of characters in $name given the encoding
    */
    public function length()
    {
        return mb_strlen($this->name, $this->encoding);
    }

    private function parser() {

        $full_name = $this->name;

        $full_name = trim(str_replace('  ', ' ', $full_name));
        $full_name = htmlspecialchars($full_name, ENT_QUOTES);

        //before explode, we need to exract salutation
        $full_name = strtolower($full_name);
        foreach ($this->salutations as $salute) {

            //var_dump($full_name);

            // salutation must start from position 0
            // if salutation found but start from > 0 then that they father salutation
            if (strpos($full_name, $salute) !== false && strpos($full_name, $salute) === 0) {
                $this->salutation = $this->fix_case($salute);
                $full_name = str_replace($salute, '', $full_name);
            }
        }

        $full_name = str_replace('  ', ' ', $full_name);
        $full_name = ucwords(strtolower(trim($full_name)));

        // split into words
        $unfiltered_name_parts = explode(' ',$full_name);

        // completely ignore any words in parentheses
        foreach ($unfiltered_name_parts as $word) {
            if ($word{0} != "(")
                $name_parts[] = $word;
        }

        $num_words = sizeof($name_parts);

        $start = 0;
        $end = $num_words;

        // concat the first name
        for ($i=$start; $i < $end-1; $i++) {
            $word = $name_parts[$i];

            // move on to parsing the last name if we find an indicator of a compound last name (Binti, Bin, , Bte, Mohd, Syed etc)
            // we use $i != $start to allow for rare cases where an indicator is actually the first name (like "Syed Cromok")
            if ($this->is_middle($word) && $i != $start)
                break;
            // is it a middle initial or part of their first name?
            // if we start off with an initial, we'll call it the first name
            $this->first .= " ".$this->fix_case($word);
        }

        // check that we have more than 1 word in our string

        if ($end-$start > 1) {
            // concat the last name
            for ($i; $i < $end; $i++) {
                $this->last .= " ".$this->fix_case($name_parts[$i]);
            }
        } else {
            // otherwise, single word strings are assumed to be first names
            $this->first = $this->fix_case($name_parts[$i]);
        }

        $this->first = trim($this->first);
        $this->last = trim($this->last);
    }

    private function addSalutation($salute)
    {
        if (is_array($salute)) {
            foreach ($salute as $tabik) {
                $this->salutations[] = htmlspecialchars($tabik, ENT_QUOTES);
            }
        } else {
            $this->salutations[] = htmlspecialchars($salute, ENT_QUOTES);
        }
    }

    private function addMiddle($middle)
    {
        if (is_array($middle)) {
            foreach ($middle as $mid) {
                $this->middles[] = $mid;
            }
        } else {
            $this->middles[] = $middle;
        }
    }

    // detect compound last names like "Syed Cromok"
    private function is_middle($word) {
        $word = strtolower($word);
        return array_search($word,$this->middles);
    }

    // detect mixed case words like "McDonald"
    // returns false if the string is all one case
    private function is_camel_case($word) {
        if (preg_match("|[A-Z]+|s", $word) && preg_match("|[a-z]+|s", $word))
            return true;
        return false;
    }

    // ucfirst words split by dashes or periods
    // ucfirst all upper/lower strings, but leave camelcase words alone
    private function fix_case($word) {
        // uppercase words split by dashes, like "Kimura-Fay"
        $word = $this->safe_ucfirst("-",$word);
        // uppercase words split by periods, like "J.P."
        $word = $this->safe_ucfirst(".",$word);
        $word = $this->safe_ucfirst(" ",$word);
        $word = $this->safe_ucfirst("@",$word);
        $word = $this->safe_ucfirst("/",$word);
        return $word;
    }

    // helper public function for fix_case
    public function safe_ucfirst($seperator, $word) {
        // uppercase words split by the seperator (ex. dashes or periods)
        $parts = explode($seperator,$word);
        foreach ($parts as $word) {
            $words[] = ($this->is_camel_case($word)) ? $word : ucfirst(strtolower($word));
        }
        return implode($seperator,$words);
    }

}
