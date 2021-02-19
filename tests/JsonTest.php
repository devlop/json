<?php

declare(strict_types=1);

namespace Devlop\Json\Tests;

use Devlop\Json\Json;
use PHPUnit\Framework\TestCase;

final class JsonTest extends TestCase
{
    public function test_it_cannot_be_constructed() : void
    {
        $this->expectException(\Error::class);

        $json = new Json;
    }

    public function test_no_flags_const_is_of_type_integer_with_value_zero() : void
    {
        $this->assertIsInt(Json::NO_FLAGS);

        $this->assertEquals(0, Json::NO_FLAGS);
    }
}
