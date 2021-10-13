<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use PHPUnit\Framework\TestCase;

final class JsonDecodeAssocTest extends TestCase
{
    /** @test */
    public function decode_assoc_decodes_array_as_sequential_array() : void
    {
        $output = Json::decodeAssoc('[1,2,3]');

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
    public function decode_assoc_decodes_key_value_object_as_assoc_array() : void
    {
        $output = Json::decodeAssoc('{"first":1,"second":2,"third":3}');

        $this->assertIsArray($output);

        $expectedOutput = [
            'first' => 1,
            'second' => 2,
            'third' => 3,
        ];

        $this->assertEquals($expectedOutput, $output);
    }
}
