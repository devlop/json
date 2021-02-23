<p align="center">
    <a href="https://packagist.org/packages/devlop/json"><img src="https://img.shields.io/packagist/v/devlop/json" alt="Latest Stable Version"></a>
    <a href="https://github.com/devlop-ab/json/blob/master/LICENSE.md"><img src="https://img.shields.io/packagist/l/devlop/json" alt="License"></a>
</p>

# Json

JSON wrapper that provide better developer experiance than the native `json_encode` and `json_decode`.

# Installation

```bash
composer require devlop/json
```

# Differences to json_encode / json_decode

* Always throws `\JsonException` on errors
* Consistent order of arguments (`$value`/`$json`, `$flags`, `$depth`)
* Stricter when encoding and decoding, only supports arrays and objects, does not support scalar values

# Usage

Both encode and decode are static methods and have the same order of arguments: `first the input`, followed by `int $flags` and lastly `int $depth`.

## Encoding

The `encode` method is a wrapper for the native [json_encode](https://www.php.net/manual/en/function.json-encode.php) method.

Signature: `public static function encode(array|object $value, int $flags = 0, int $depth = 512) : string`

```php
use Devlop\Json\Json;

$output = Json::encode($input);

// or with flags
$output = Json::encode($input, \JSON_HEX_TAG | \JSON_NUMERIC_CHECK);
```

## Encoding (Pretty Print)

The `pretty` method is a convenience method to get pretty formatted output without having
to manually specify the [`JSON_PRETTY_PRINT`](https://www.php.net/manual/en/json.constants.php#constant.json-pretty-print) flag.

It has the same signature as `encode()`.

```php
use Devlop\Json\Json;

$output = Json::pretty($input);

// or with flags
$output = Json::encode($input, \JSON_HEX_TAG | \JSON_NUMERIC_CHECK);
```

## Decoding

The `decode` method is a wrapper for the native [json_decode](https://www.php.net/manual/en/function.json-decode.php) method.

Signature: `public static function decode(string $json, int $flags = 0, int $depth = 512) : array|object`

```php
use Devlop\Json\Json;

$output = Json::decode($input);

// or with flags
$output = Json::decode($input, \JSON_INVALID_UTF8_IGNORE);
```

## Decoding (Associative)

The `decodeAssoc` method is a convenience method to decode but force all objects to associative arrays without having to
manually specify the [`JSON_OBJECT_AS_ARRAY`](https://www.php.net/manual/en/json.constants.php#constant.json-object-as-array) flag.

It has the same signature as `decode()`.

```php
use Devlop\Json\Json;

$output = Json::decodeAssoc($input);

// or with flags
$output = Json::decodeAssoc($input, \JSON_INVALID_UTF8_IGNORE);
```

# Error handling

Any time an error occurs the native `JsonException` will be thrown.

# Supported types

My belief is that the most common usage of JSON in PHP is to store a JSON representation of arrays or objects.
It is true that a single string, integer, boolean or even a single null value is a valid JSON document, but
if you are as me and only using JSON for arrays or objects then it's just easier to treat anything else as
invalid data and throw an exception, this removes some of the need to check the type after decoding.

# depth argument and NO_FLAGS

If you want to access the $depth argument without adding any additional flags, you must supply the default value `0` for the `$flags` argument,
but to make the experiance more clearer you can use the constant `Json::NO_FLAGS` instead.

```php
$output = Json::encode($input, Json::NO_FLAGS, 3);
```
