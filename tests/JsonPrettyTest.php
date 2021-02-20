<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use Devlop\Json\Tests\Assertions\AssertException;
use PHPUnit\Framework\TestCase;

final class JsonPrettyTest extends TestCase
{
    use AssertException;

    public function test_pretty_produces_formatted_output() : void
    {
        $output = Json::pretty([
            'first' => 1,
            'second' => 2,
            'third' => 3,
        ]);

        $expectedOutput = <<<'txt'
            {
                "first": 1,
                "second": 2,
                "third": 3
            }
            txt;

        $this->assertEquals($expectedOutput, $output);
    }

    public function test_pretty_internally_invokes_encode_method() : void
    {
        // learn mocking
    }
}
