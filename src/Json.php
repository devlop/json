<?php

declare(strict_types=1);

namespace Devlop\Json;

use JsonException;

/**
 * Encodes/decodes JSON, always throws on error
 *
 * @link https://www.php.net/manual/en/json.constants.php#constant.json-throw-on-error
 */
final class Json
{
    public const NO_FLAGS = 0;

    private function __construct()
    {
        // not meant to be instantiated
    }

    private static function assertCanEncode($value) : void
    {
        if (! is_array($value) && ! is_object($value)) {
            throw new JsonException(
                'A value of a type that cannot be encoded was given, only arrays and objects are supported.',
                \JSON_ERROR_UNSUPPORTED_TYPE,
            );
        }
    }

    private static function assertCanDecode($value) : void
    {
        $ends = mb_substr($value, 0, 1) . mb_substr($value, -1);

        if (! in_array($ends, ['[]', '{}'], true)) {
            throw new JsonException(
                'Invalid or malformed JSON, only arrays and objects are supported.',
                \JSON_ERROR_UNSUPPORTED_TYPE,
            );
        }
    }

    /**
     * Encode as JSON
     *
     * @link https://www.php.net/manual/en/function.json-encode.php
     *
     * @param  array|object  $value
     * @param  int  $flags
     * @param  int  $depth
     * @return string
     *
     * @throws JsonException
     */
    public static function encode($value, int $flags = 0, int $depth = 512) : string
    {
        self::assertCanEncode($value);

        return \json_encode(
            $value,
            $flags | \JSON_THROW_ON_ERROR,
            $depth,
        );
    }

    /**
     * Encode as JSON and format "pretty print" using whitespace.
     *
     * @link https://www.php.net/manual/en/function.json-encode.php
     * @link https://www.php.net/manual/en/json.constants.php#constant.json-pretty-print
     *
     * @param  array|object  $value
     * @param  int  $flags
     * @param  int  $depth
     * @return string
     *
     * @throws JsonException
     */
    public static function pretty($value, int $flags = 0, int $depth = 512) : string
    {
        return self::encode(
            $value,
            $flags | \JSON_PRETTY_PRINT,
            $depth,
        );
    }

    /**
     * Decodes a JSON string.
     *
     * @link https://www.php.net/manual/en/function.json-decode.php
     *
     * @param  string  $json
     * @param  int  $flags
     * @param  int  $depth
     * @return array|object
     *
     * @throws JsonException
     */
    public static function decode(string $json, int $flags = 0, int $depth = 512)
    {
        self::assertCanDecode($json);

        return \json_decode(
            $json,
            null,
            $depth,
            $flags | \JSON_THROW_ON_ERROR,
        );
    }

    /**
     * Decodes a JSON string as an associative array.
     *
     * @link https://www.php.net/manual/en/function.json-decode.php
     *
     * @param  string  $json
     * @param  int  $flags
     * @param  int  $depth
     * @return array
     *
     * @throws JsonException
     */
    public static function decodeAssoc(string $json, int $flags = 0, int $depth = 512) : array
    {
        return self::decode(
            $json,
            $flags | \JSON_OBJECT_AS_ARRAY,
            $depth,
        );
    }
}
