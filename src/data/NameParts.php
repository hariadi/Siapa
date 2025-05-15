<?php

namespace Hariadi\Siapa\Data;

class NameParts
{
    public ?string $salutation;
    public string $firstName;
    public string $lastName;
    public string $gender;

    public function __construct(?string $salutation, string $firstName, string $lastName, string $gender = 'M')
    {
        $this->salutation = $salutation;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
    }
}
