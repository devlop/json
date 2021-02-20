<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use Devlop\Json\Tests\Assertions\AssertException;
use PHPUnit\Framework\TestCase;

final class JsonEncodeTest extends TestCase
{
    use AssertException;

    public function test_encodes_integer_values_array() : void
    {
        $output = Json::encode([
            1,
            2,
            3,
        ]);

        $expectedOutput = '[1,2,3]';

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_encodes_string_values_array() : void
    {
        $output = Json::encode([
            'one',
            'two',
            'three',
        ]);

        $expectedOutput = '["one","two","three"]';

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_encodes_keyed_integer_values_array() : void
    {
        $output = Json::encode([
            'first' => 1,
            'second' => 2,
            'third' => 3,
        ]);

        $expectedOutput = '{"first":1,"second":2,"third":3}';

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_encodes_keyed_string_values_array() : void
    {
        $output = Json::encode([
            'first' => 'one',
            'second' => 'two',
            'third' => 'three',
        ]);

        $expectedOutput = '{"first":"one","second":"two","third":"three"}';

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_encodes_object() : void
    {
        $object = new class {
            public string $name = 'The Numbers';
            public array $numbers = [4, 8, 15, 16, 23, 42];
        };

        $output = Json::encode($object);

        $expectedOutput = '{"name":"The Numbers","numbers":[4,8,15,16,23,42]}';

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_encodes_json_serializable_object() : void
    {
        $object = new class implements \JsonSerializable {
            public string $name = 'The Numbers';
            public array $numbers = [4, 8, 15, 16, 23, 42];

            public function jsonSerialize() : array
            {
                return [
                    'name' => $this->name,
                ];
            }
        };

        $output = Json::encode($object);

        $expectedOutput = '{"name":"The Numbers"}';

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_encode_flags_argument() : void
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

        foreach ($flags as $flag => $expectedOutput) {
            $output = Json::encode($input, $flag);

            $this->assertEquals($expectedOutput, $output);
        }
    }

    public function test_encode_depth_argument() : void
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

    public function test_does_not_encode_scalar_or_null_arguments() : void
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
                Json::pretty($argument);
            });
        }
    }

    public function test_encodes_array_and_objects() : void
    {
        $arguments = [
            [1, 2, 3],
            (object) [1, 2, 3],
        ];

        foreach ($arguments as $argument) {
            // $this->assertException(\JsonException::class, function () use ($argument) {
            //     Json::pretty($argument);
            // });
        }
    }
}
