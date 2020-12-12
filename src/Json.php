<?php

declare(strict_types=1);

namespace Devlop\Json;

use JsonException;

final class Json
{
    private function __construct()
    {
        // not meant to be instantiated
    }

    /**
     * Decodes a JSON string
     *
     * @link https://www.php.net/manual/en/function.json-decode.php
     *
     * @param  string  $json
     * @return mixed
     *
     * @throws JsonException
     */
    public static function decode(string $json)
    {
        return \json_decode(
            $json,
            null,
            512,
            \JSON_THROW_ON_ERROR,
        );
    }

    /**
     * Decodes a JSON string and return JSON objects as associative arrays
     *
     * @link https://www.php.net/manual/en/function.json-decode.php
     *
     * @param  string  $json
     * @return mixed
     *
     * @throws JsonException
     */
    public static function decodeAssoc(string $json)
    {
        return \json_decode(
            $json,
            null,
            512,
            \JSON_THROW_ON_ERROR | \JSON_OBJECT_AS_ARRAY,
        );
    }

    /**
     * Returns the JSON representation of a value
     *
     * @link https://www.php.net/manual/en/function.json-encode.php
     *
     * @param  mixed  $value
     * @return string
     *
     * @throws JsonException
     */
    public static function encode($value) : string
    {
        return \json_encode(
            $value,
            \JSON_THROW_ON_ERROR,
        );
    }
}
