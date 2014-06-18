# Siapa [![Build Status](https://travis-ci.org/hariadi/Siapa.png)](https://travis-ci.org/hariadi/Siapa)

Malay Name Parser: A simple script for parsing complex Malay names into their individual components.

- Salutation
- First Name
- Last Name
- Gender

## Example Usage

```php
$siapa = Siapa::name("Dato' Dr. Ir Hj. Hariadi Bin Hinta");
echo $siapa->salutation(); // Dato&#039; Dr. Ir Hj.
echo $siapa->first(); // Hariadi
echo $siapa->last(); // Bin Hinta
echo $siapa->gender(); // M (not very accurate ;p)
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

$siapa->gender(boolean $short)

Siapa::gender(boolean $short)

Returns the gender of name. Default param is `true` for short gender (M for Male and F for Female).

```php
Siapa::name('Hariadi Hinta', 'UTF-8')->gender(false); // Male
```

Algorithm to detect malay name gender:
0. Default gender is Male
1. Check if `Binti`, `Bte.`, `Bte`, `Puan`, `Puan`, `Pn.`, `Bt.`, `Bt`, `A/P` exist in first name
2. If not found then we check for salutation if `Hajah`, `Hajjah`, `Hjh.`, `Puan`, `Pn.`, `Cik` exist.
3. If not found then we check for common female malay name in [`female.txt`](https://github.com/hariadi/Siapa/blob/master/src/data/female.txt) library


## Tests

1. Clone the repository: git clone https://github.com/hariadi/Siapa.git
2. From the project directory, tests can be ran using `phpunit`

## License

Released under the MIT License - see `LICENSE.txt` for details.
