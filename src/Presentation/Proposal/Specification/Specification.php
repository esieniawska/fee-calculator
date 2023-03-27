<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Presentation\Proposal\Specification;

interface Specification
{
    public function isSatisfiedBy(?string $value): bool;
}
