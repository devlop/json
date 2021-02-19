<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use Devlop\Json\Tests\Assertions\AssertException;
use PHPUnit\Framework\TestCase;

final class JsonPrettyTest extends TestCase
{
    use AssertException;

    public function test_pretty_encodes_formatted_output() : void
    {
        $output = Json::pretty([
            'first' => 1,
            'second' => 2,
            'third' => 3,
        ]);

        $expected = <<<'txt'
            {
                "first": 1,
                "second": 2,
                "third": 3
            }
            txt;

        $this->assertEquals($expected, $output);
    }

    public function test_pretty_only_accepts_array_or_object() : void
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
}
