<?php

namespace Hariadi\Siapa;

use Hariadi\Siapa\Parser\MalayNameParser;

class Siapa
{
    protected MalayNameParser $parser;
    protected string $raw;

    public function __construct(string $name)
    {
        $this->raw = $name;
        $this->parser = new MalayNameParser();
    }

    public static function name(string $name): static
    {
        return new self($name);
    }

    public function parse(): array
    {
        $parts = $this->parser->parse($this->raw);

        return [
            'salutation' => $parts->salutation,
            'first' => $parts->firstName,
            'last' => $parts->lastName,
            'gender' => $parts->gender,
        ];
    }

    public function __toString(): string
    {
        return $this->raw;
    }
}
