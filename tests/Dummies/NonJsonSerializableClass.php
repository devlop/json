<?php

declare(strict_types=1);

namespace Devlop\Json\Tests\Dummies;

final class NonJsonSerializableClass
{
    public string $name;

    public array $secrets;

    public function __construct(string $name, array $secrets = [])
    {
        $this->name = $name;

        $this->secrets = $secrets;
    }
}
