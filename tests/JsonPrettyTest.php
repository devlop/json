<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use PHPUnit\Framework\TestCase;

final class JsonPrettyTest extends TestCase
{
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
}
