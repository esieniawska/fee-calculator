<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Shared\ValueObject;

class Money extends ValueObject
{
    public function __construct(private int $value)
    {
    }

    public function getFloatValue(): float
    {
        return $this->value / 100;
    }

    public function getIntValue(): int
    {
        return $this->value;
    }
}
