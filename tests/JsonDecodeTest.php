<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use PHPUnit\Framework\TestCase;

final class JsonDecodeTest extends TestCase
{
    public function test_decode_sequential_array() : void
    {
        $output = Json::decode('[1,2,3]');

        $this->assertEquals([1,2,3], $output);
    }

    public function test_decode_key_value_object() : void
    {
        $output = Json::decode('{"first":1,"second":2,"third":3}');

        $expected = (object) [
            'first' => 1,
            'second' => 2,
            'third' => 3,
        ];

        $this->assertEquals($expected, $output);
    }
}
