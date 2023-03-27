<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Presentation\Proposal\Specification;

readonly class StringIsNotNullSpecification implements Specification
{
    public function isSatisfiedBy(?string $value): bool
    {
        return !is_null($value);
    }
}
