<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use Devlop\PHPUnit\ExceptionAssertions;
use JsonException;
use PHPUnit\Framework\TestCase;

final class JsonDecodeTest extends TestCase
{
    use ExceptionAssertions;

    /** @test */
    public function decodes_integer_values_array() : void
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

    /** @test */
    public function decodes_string_values_array() : void
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

    /** @test */
    public function decodes_key_value_object_as_object() : void
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

    /** @test */
    public function decode_flags_argument() : void
    {
        $output = Json::decode(
            '{"number":1234567890123456789012345678901234567890}',
            \JSON_BIGINT_AS_STRING
        );

        $expectedOutput = (object) [
            'number' => '1234567890123456789012345678901234567890',
        ];

        $this->assertEquals($expectedOutput, $output);
    }

    /** @test */
    public function decode_depth_argument() : void
    {
        $this->assertExceptionThrown(JsonException::class, function () {
            Json::decode('{"first":["second"]}', Json::NO_FLAGS, 1);
        });
    }

    /** @test */
    public function does_not_decode_scalar_or_null() : void
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
            $this->assertExceptionThrown(JsonException::class, function () use ($argument) {
                Json::decodeAssoc($argument);
            });
        }
    }
}
