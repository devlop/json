<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use Devlop\Json\Tests\Assertions\AssertException;
use Devlop\Json\Tests\Dummies\JsonSerializableClass;
use Devlop\Json\Tests\Dummies\NonJsonSerializableClass;
use PHPUnit\Framework\TestCase;

final class JsonEncodeTest extends TestCase
{
    use AssertException;

    public function test_encodes_array_with_numeric_values() : void
    {
        $output = Json::encode([
            1,
            2,
            3,
        ]);

        $this->assertEquals('[1,2,3]', $output);
    }

    public function test_encodes_array_with_string_values() : void
    {
        $output = Json::encode([
            'one',
            'two',
            'three',
        ]);

        $this->assertEquals('["one","two","three"]', $output);
    }

    public function test_encodes_associative_array_with_numeric_values() : void
    {
        $output = Json::encode([
            'first' => 1,
            'second' => 2,
            'third' => 3,
        ]);

        $this->assertEquals('{"first":1,"second":2,"third":3}', $output);
    }

    public function test_encodes_associative_array_with_string_values() : void
    {
        $output = Json::encode([
            'first' => 'one',
            'second' => 'two',
            'third' => 'three',
        ]);

        $this->assertEquals('{"first":"one","second":"two","third":"three"}', $output);
    }

    public function test_encodes_non_json_serializable_class() : void
    {
        $output = Json::encode(new NonJsonSerializableClass('Johan', [4, 8, 15, 16, 23, 42]));

        $this->assertEquals('{"name":"Johan","secrets":[4,8,15,16,23,42]}', $output);
    }

    public function test_encodes_json_serializable_class() : void
    {
        $output = Json::encode(new JsonSerializableClass('Johan', [4, 8, 15, 16, 23, 42]));

        $this->assertEquals('{"name":"Johan","secrets":[42,23,16,15,8,4],"sum":108}', $output);
    }

    public function test_flags_are_honored_when_encoding() : void
    {
        $input = [
            '1',
            '2',
            '3',
        ];

        foreach ($input as $value) {
            // why? just to make it impossible to change the input to integers
            // by accident and get a false positive in the output assertion
            $this->assertIsString($value);
        }

        $flags = [
            \JSON_FORCE_OBJECT => '{"0":"1","1":"2","2":"3"}',
            \JSON_NUMERIC_CHECK => '[1,2,3]',
            \JSON_FORCE_OBJECT | \JSON_NUMERIC_CHECK => '{"0":1,"1":2,"2":3}',
        ];

        foreach ($flags as $flag => $output) {
            $this->assertEquals($output, Json::encode($input, $flag));
        }
    }

    public function test_depth_value_is_honored_when_encoding() : void
    {
        $this->expectException(\JsonException::class);

        try {
            $output = Json::encode([
                'first' => 'one',
                'second' => 'two',
                'third' => [
                    'three',
                    'four',
                    'five',
                ],
            ], Json::NO_FLAGS, 1);
        } catch (\JsonException $e) {
            $this->assertEquals('Maximum stack depth exceeded', $e->getMessage());

            throw $e;
        }
    }

    public function test_encodes_only_accepts_array_or_object() : void
    {
        $arguments = [
            'string',
            1,
            1.5,
            false,
            true,
            null,
        ];

        foreach ($arguments as $argument) {
            $this->assertException(\JsonException::class, function () use ($argument) {
                Json::encode($argument);
            });
        }
    }
}
