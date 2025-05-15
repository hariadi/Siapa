<?php

use PHPUnit\Framework\TestCase;
use Hariadi\Siapa\Siapa;

class SiapaTest extends TestCase
{
    /**
     * @dataProvider provider
     */
    public function testNameParsing(string $fullName, array $expected)
    {
        $siapa = new Siapa($fullName);
        $parsed = $siapa->parse();

        $this->assertSame($expected[0], $parsed['salutation']);
        $this->assertSame($expected[1], $parsed['first']);
        $this->assertSame($expected[2], $parsed['last']);
        $this->assertSame($expected[3], $parsed['gender']);
        $this->assertSame($expected[4], $parsed['first'] . ' ' . $parsed['last']);
    }

    /**
     * @return array
     */
    public function provider(): array
    {
        return [
            [
                'Hariadi Hinta',
                [
                    null,
                    'Hariadi',
                    'Hinta',
                    'M',
                    'Hariadi Hinta'
                ]
            ],
            [
                'En. Hariadi Hinta',
                [
                    'En.',
                    'Hariadi',
                    'Hinta',
                    'M',
                    'Hariadi Hinta'
                ]
            ],
            [
                'En. Hariadi bin Hinta',
                [
                    'En.',
                    'Hariadi',
                    'Hinta',
                    'M',
                    'Hariadi Hinta'
                ]
            ],
            [
                "Dato' Dr. Ir. Hj. Hariadi Bin Hinta",
                [
                    "Dato' Dr. Ir. Hj.",
                    'Hariadi',
                    'Hinta',
                    'M',
                    'Hariadi Hinta'
                ]
            ],
            [
                'pn. nur hariadi hinta',
                [
                    'Pn.',
                    'Nur Hariadi',
                    'Hinta',
                    'F',
                    'Nur Hariadi Hinta'
                ]
            ],
        ];
    }
}
