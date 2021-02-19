<?php

declare(strict_types=1);

namespace Devlop\Json\Tests\Assertions;

use Throwable;

trait AssertException
{
    /**
     * Assert that a specific exception is thrown
     *
     * @param  class-string  $expectedException
     * @param  callable  $callback
     * @return void
     */
    protected function assertException(string $expectedException, callable $callback) : void
    {
        $thrownException = null;

        try {
            $callback();
        } catch (Throwable $e) {
            $thrownException = $e;
        }

        $this->assertInstanceOf(
            $expectedException,
            $thrownException,
            $thrownException === null
                ? sprintf('Failed asserting that exception of type "%1$s" was thrown, no exception was thrown.', $expectedException)
                : sprintf(
                    'Failed asserting that exception of type "%1$s" was thrown, the thrown exception was of type "%2$s".',
                    $expectedException,
                    \get_debug_type($thrownException),
                ),
        );
    }
}
