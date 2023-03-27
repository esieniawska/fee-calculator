<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Presentation\Proposal\Specification;

readonly class ValueIsBetweenAcceptedValuesSpecification implements Specification
{
    public function __construct(private array $correctValues)
    {
    }

    public function isSatisfiedBy(?string $value): bool
    {
        return in_array($value, $this->correctValues);
    }
}
