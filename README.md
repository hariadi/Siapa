# Siapa [![Build Status](https://travis-ci.org/hariadi/Siapa.png)](https://travis-ci.org/hariadi/Siapa)

Malay Name Parser: A simple script for parsing complex Malay names into their individual components.

- Salutation
- First Name
- Last Name
- Gender

## Example Usage

```php
$siapa = Siapa::name("Dato' Dr. Ir Hj. Hariadi Hinta");
echo $siapa->salutation();
echo $siapa->first();
echo $siapa->last();
echo $siapa->gender(); // not very accurate
```

## Requiring/Loading

If you're using Composer to manage dependencies, you can include the following
in your composer.json file:

    "require": {
        "hariadi/siapa": ">=0.1.0"
    }

Then, after running `composer update` or `php composer.phar update`, you can
load the class using Composer's autoloading:

```php
require 'vendor/autoload.php';
```

Otherwise, you can simply require the file directly:

```php
require_once 'path/to/Siapa/src/Siapa.php';
```

## OO and Procedural

The library offers both OO method chaining with `Hariadi\Siapa`. An example
of the former is the following:

```php
use Hariadi\Siapa as Siapa;
echo Siapa::name('Hariadi Hinta', 'UTF-8')->first();  // 'Hariadi'
```

## Methods

*Note: If `$encoding` is not given, it defaults to `mb_internal_encoding()`.*

#### salutation

$siapa->salutation()

Siapa::salutation()

Returns salutation from full name.

```php
Siapa::name('Datuk Dr. Ir. Hariadi Hinta', 'UTF-8')->salutation(); // Datuk Dr. Ir.
```

#### first

$siapa->first()

Siapa::first()

Returns the first name.

```php
Siapa::name('Hariadi Hinta', 'UTF-8')->first(); // Hariadi
```

#### last

$siapa->last()

Siapa::last()

Returns the last name.

```php
Siapa::name('Hariadi Hinta', 'UTF-8')->last(); // Hinta
```

#### gender

$siapa->gender()

Siapa::gender()

Returns the gender of name.

```php
Siapa::name('Hariadi Hinta', 'UTF-8')->gender(false); // Male
```

## Tests

1. Clone the repository: git clone https://github.com/hariadi/Siapa.git
2. From the project directory, tests can be ran using `phpunit`

## License

Released under the MIT License - see `LICENSE.txt` for details.
