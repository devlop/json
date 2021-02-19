<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use Devlop\Json\Tests\Assertions\AssertException;
use PHPUnit\Framework\TestCase;

final class JsonDecodeAssocTest extends TestCase
{
    use AssertException;

    public function test_decode_assoc_sequential_array_as_usual() : void
    {
        $output = Json::decodeAssoc('[1,2,3]');

        $this->assertEquals([1,2,3], $output);
    }

    public function test_decode_assoc_key_value_object_as_assoc_array() : void
    {
        $output = Json::decodeAssoc('{"first":1,"second":2,"third":3}');

        $expected = [
            'first' => 1,
            'second' => 2,
            'third' => 3,
        ];

        $this->assertEquals($expected, $output);
    }

    public function test_decode_assoc_only_decodes_arrays_and_objects() : void
    {
        $arguments = [
            '"string"',
            "1",
            "1.5",
            "false",
            "true",
            "null",
            "",
        ];

        foreach ($arguments as $argument) {
            $this->assertException(\JsonException::class, function () use ($argument) {
                Json::decodeAssoc($argument);
            });
        }
    }
}
