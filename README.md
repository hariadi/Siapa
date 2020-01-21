# Siapa [![Build Status](https://travis-ci.org/hariadi/Siapa.png)](https://travis-ci.org/hariadi/Siapa)

Malay Name Parser: A simple script for parsing complex Malay names into their individual components.

- Salutation
- First Name
- Last Name
- Gender

## Example Usage

```php
$siapa = Siapa::name("Dato' Dr. Ir Hj. Hariadi Bin Hinta");
echo $siapa->salutation(); // Dato' Dr. Ir Hj.
echo $siapa->first(); // Hariadi
echo $siapa->last(); // Bin Hinta
echo $siapa->gender(); // M
```

## Install

If you're using Composer to manage dependencies, you can include the following
in your composer.json file:

    `composer require hariadi/siapa`

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
use Hariadi\Siapa;
echo Siapa::name('Hariadi Hinta', 'UTF-8')->first();  // Hariadi
```

## Methods

*Note: If `$encoding` is not given, it defaults to `mb_internal_encoding()`.*

#### salutation

`$siapa->salutation()`

`Siapa::salutation()`

Returns salutation from full name.

```php
Siapa::name('Datuk Dr. Ir. Hariadi Hinta', 'UTF-8')->salutation(); // Datuk Dr. Ir.
```

#### givenName

`Siapa::givenName()`

Returns the combine of first and last name without salutation and optional with or witout middle name.

```php
Siapa::name('Dato\' Hariadi Bin Hinta', 'UTF-8')->givenName(false); // Hariadi Bin Hinta
```

#### first

`Siapa::first()`

Returns the first name.

```php
Siapa::name('Hariadi Hinta', 'UTF-8')->first(); // Hariadi
```

#### last

`Siapa::last()`

Returns the last name.

```php
Siapa::name('Hariadi Hinta', 'UTF-8')->last(); // Hinta
```

#### gender

`Siapa::gender(boolean $short)`

Returns the gender of name. Default param is `true` for short gender (M for Male and F for Female).

```php
Siapa::name('Hariadi Hinta', 'UTF-8')->gender(false); // Male
```

Algorithm to detect malay name gender:
- Default gender is Male
- Check if `Binti`, `Bte.`, `Bte`, `Puan`, `Puan`, `Pn.`, `Bt.`, `Bt`, `A/P` exist in first name
- If not found then we check for salutation if `Hajah`, `Hajjah`, `Hjh.`, `Puan`, `Pn.`, `Cik` exist.
- If not found then we check for common female malay name in [`female.txt`](https://github.com/hariadi/Siapa/blob/master/src/data/female.txt) library


## Tests

1. Clone the repository: git clone https://github.com/hariadi/Siapa.git
2. From the project directory, tests can be ran using `phpunit`

## License

Released under the MIT License - see `LICENSE.txt` for details.
