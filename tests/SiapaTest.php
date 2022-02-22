<?php

namespace Hariadi\Siapa;

use PHPUnit\Framework\TestCase;

class SiapaTest extends TestCase
{
    /**
     * @return array
     */
    public function provider(): array
    {
        return [
            [
                'Hariadi Hinta',
                [
                    '',
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
                    'Bin Hinta',
                    'M',
                    'Hariadi Hinta'
                ]
            ],
            [
                'Dato\' Dr. Ir. Hj. Hariadi Bin Hinta',
                [
                    'Dato\' Dr. Ir. Hj.',
                    'Hariadi',
                    'Bin Hinta',
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

    /**
     * @dataProvider provider
     */
    public function testParse($input, $expectation)
    {
        $siapa = new Siapa($input);

        $this->assertInstanceOf(Siapa::class, $siapa);
        $this->assertEquals($expectation, [
            $siapa->salutation(),
            $siapa->first(),
            $siapa->last(),
            $siapa->gender(),
            $siapa->givenName()
        ]);
    }
}
