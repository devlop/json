<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use Devlop\Json\Tests\Assertions\AssertException;
use PHPUnit\Framework\TestCase;

final class JsonDecodeTest extends TestCase
{
    use AssertException;

    public function test_decodes_integer_values_array() : void
    {
        $output = Json::decode('[1,2,3]');

        $this->assertIsArray($output);
        $this->assertTrue(array_is_list($output));

        $expectedOutput = [
            1,
            2,
            3,
        ];

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_decodes_string_values_array() : void
    {
        $output = Json::decode('["one","two","three"]');

        $this->assertIsArray($output);
        $this->assertTrue(array_is_list($output));

        $expectedOutput = [
            'one',
            'two',
            'three',
        ];

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_decodes_key_value_object_as_object() : void
    {
        $output = Json::decode('{"first":1,"second":2,"third":3}');

        $this->assertIsObject($output);

        $expectedOutput = (object) [
            'first' => 1,
            'second' => 2,
            'third' => 3,
        ];

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_decode_flags_argument() : void
    {
        //
    }

    public function test_decode_depth_argument() : void
    {
        //
    }

    public function test_does_not_decode_scalar_or_null() : void
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

    public function test_pretty_internally_invokes_encode_method() : void
    {
        // learn mocking
    }
}
