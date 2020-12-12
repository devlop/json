<?php

declare(strict_types=1);

namespace Devlop\Json;

final class Json
{

    private function __construct()
    {

    }

    public static function decode(string $json, int $depth = 512) : array
    {
        dd(__METHOD__);
    }
}
