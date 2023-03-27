<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Presentation\Proposal\Specification;

readonly class StringHasValidPatternSpecification implements Specification
{
    public function __construct(private string $pattern)
    {
    }

    public function isSatisfiedBy(?string $value): bool
    {
        return 1 === preg_match($this->pattern, $value);
    }
}
