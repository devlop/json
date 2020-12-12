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
     * @param  int  $depth
     * @return mixed
     *
     * @throws JsonException
     */
    public static function decode(string $json, int $depth = 512)
    {
        return \json_decode(
            $json,
            null,
            $depth,
            \JSON_THROW_ON_ERROR,
        );
    }

    /**
     * Decodes a JSON string and return JSON objects as associative arrays
     *
     * @link https://www.php.net/manual/en/function.json-decode.php
     *
     * @param  string  $json
     * @param  int  $depth
     * @return mixed
     *
     * @throws JsonException
     */
    public static function decodeAssoc(string $json, int $depth = 512)
    {
        return \json_decode(
            $json,
            null,
            $depth,
            \JSON_THROW_ON_ERROR | \JSON_OBJECT_AS_ARRAY,
        );
    }
}
