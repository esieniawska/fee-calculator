<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Model;

readonly class FeeStructure
{
    public function __construct(private array $loadFees)
    {
    }

    public function getLoadFees(): array
    {
        return $this->loadFees;
    }
}
