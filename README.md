# Siapa&#x20;

**Malay Name Parser**
A smart parser for extracting components from complex Malay names:

* ✅ Salutation
* ✅ First Name
* ✅ Last Name (excluding patronyms like "bin"/"binti")
* ✅ Gender detection

---

## 💡 Example Usage

```php
use Hariadi\Siapa\Siapa;

$siapa = Siapa::name("Dato' Dr. Ir. Hj. Hariadi Bin Hinta");

echo $siapa->salutation(); // Dato' Dr. Ir. Hj.
echo $siapa->first();      // Hariadi
echo $siapa->last();       // Hinta
echo $siapa->gender();     // M
```

---

## 📦 Install

Install via Composer:

```bash
composer require hariadi/siapa
```

Then include the autoloader:

```php
require 'vendor/autoload.php';
```

Alternatively, require the class manually:

```php
require_once 'path/to/Siapa/src/Siapa.php';
```

---

## 🧱 Object-Oriented Usage

```php
use Hariadi\Siapa\Siapa;

$siapa = Siapa::name('Hariadi Hinta', 'UTF-8');
echo $siapa->first(); // Hariadi
```

---

## 🧪 Methods

> If `$encoding` is not provided, it defaults to `mb_internal_encoding()`.

### `salutation()`

Returns the full salutation, if detected.

```php
Siapa::name('Datuk Dr. Ir. Hariadi Hinta')->salutation(); // Datuk Dr. Ir.
```

### `givenName(bool $withMiddle = false)`

Returns full name without salutation. Optionally excludes middle markers (e.g., bin, binti).

```php
Siapa::name("Dato' Hariadi Bin Hinta")->givenName();       // Hariadi Hinta
Siapa::name("Dato' Hariadi Bin Hinta")->givenName(true);  // Hariadi Bin Hinta
```

### `first()`

Returns the detected first name:

```php
Siapa::name('Hariadi Hinta')->first(); // Hariadi
```

### `last()`

Returns the last name (without bin/binti):

```php
Siapa::name('Hariadi Bin Hinta')->last(); // Hinta
```

### `gender(bool $short = true)`

Detects gender. Returns `'M'`/`'F'` or `'Male'`/`'Female'`.

```php
Siapa::name('Pn. Nurul Hidayah')->gender();      // F
Siapa::name('Pn. Nurul Hidayah')->gender(false); // Female
```

#### Gender Detection Heuristics

1. Defaults to **Male**
2. If last name contains any of:

   * `Binti`, `Bte`, `A/P`, `Pn.`, `Puan`, `Cik` etc.
3. If salutation contains female honorifics
4. If first name matches any name in [`female.txt`](src/Data/female.txt)

---

## ✅ Tests

Run tests using PHPUnit:

```bash
git clone https://github.com/hariadi/Siapa.git
cd Siapa
vendor/bin/phpunit
```

---

## 📄 License

Released under the [MIT License](LICENSE.txt).
