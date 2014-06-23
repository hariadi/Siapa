<?php

require __DIR__ . '/../src/Siapa.php';

use Hariadi\Siapa as Siapa;

class SiapaTestCase extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $siapa = new Siapa('foo bar', 'UTF-8');
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $this->assertEquals('foo bar', (string) $siapa);
        $this->assertEquals('UTF-8', $siapa->getEncoding());
    }

    public function testSetName()
    {
        $siapa = Siapa::name('foo bar', 'UTF-8');
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $this->assertEquals('foo bar', (string) $siapa);
        $this->assertEquals('UTF-8', $siapa->getEncoding());
    }

    public function testNoSalutation()
    {
        $siapa = Siapa::name("hariadi hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->salutation();
        $this->assertEquals('', $result);
    }

    public function testFirst()
    {
        $siapa = Siapa::name("En. hariadi hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->first();
        $this->assertEquals('Hariadi', $result);
    }

    public function testLast()
    {
        $siapa = Siapa::name("En. hariadi hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->last();
        $this->assertEquals('Hinta', $result);
    }

    public function testGivenName()
    {
        $siapa = Siapa::name("En. Hariadi Bin Hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->givenName();
        $this->assertEquals('Hariadi Hinta', $result);
    }

    public function testGivenNameWithMiddle()
    {
        $siapa = Siapa::name("En. Hariadi Bin Hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->givenName(true);
        $this->assertEquals('Hariadi bin Hinta', $result);
    }

    public function testEncik()
    {
        $siapa = Siapa::name("en. hariadi hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->salutation();
        $this->assertEquals('En.', $result);
    }

    public function testMultiSalutation()
    {
        $siapa = Siapa::name("Dato' Dr. Ir Hj. Hariadi Bin Hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->salutation();
        $this->assertEquals("Dato' Dr. Ir Hj.", $result);
    }

    public function testCountLibraryNames()
    {
        $siapa = Siapa::name("en. hariadi hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->getFemaleNames();
        $this->assertEquals(779, count($result));
    }

    public function testGenderFemale()
    {
        $siapa = Siapa::name("pn. nur hariadi hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->gender();
        $this->assertEquals('F', $result);
    }

    public function testGenderMale()
    {
        $siapa = Siapa::name("hariadi hinta");
        $this->assertInstanceOf('Hariadi\Siapa', $siapa);
        $result = $siapa->gender();
        $this->assertEquals('M', $result);
    }
    
}
