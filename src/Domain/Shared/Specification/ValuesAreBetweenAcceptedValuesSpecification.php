<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Shared\Specification;

readonly class ValuesAreBetweenAcceptedValuesSpecification implements Specification
{
    public function __construct(private int $minValue, private int $maxValue)
    {
    }
    public function isSatisfiedBy(float|array|int|string $value): bool
    {
        return $value >= $this->minValue && $value <= $this->maxValue;
    }
}
