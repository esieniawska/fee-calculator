<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Shared\Specification;

interface Specification
{
    public function isSatisfiedBy(string|array|int|float $value): bool;
}
