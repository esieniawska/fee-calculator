<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Application\Proposal\Dto;

readonly class FeeOutput
{
    public function __construct(private float $fee)
    {
    }

    public function getFee(): float
    {
        return $this->fee;
    }
}
