<?php

declare(strict_types=1);

namespace Devlop\Json\Tests\Dummies;

final class JsonSerializableClass implements \JsonSerializable
{
    public string $name;

    public array $secrets;

    public function __construct(string $name, array $secrets = [])
    {
        $this->name = $name;

        $this->secrets = $secrets;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'secrets' => array_reverse($this->secrets),
            'sum' => array_sum($this->secrets),
        ];
    }
}
