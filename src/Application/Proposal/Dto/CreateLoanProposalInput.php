<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Application\Proposal\Dto;

readonly class CreateLoanProposalInput
{
    public function __construct(private int $term, private int $amount)
    {
    }

    public function getTerm(): int
    {
        return $this->term;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
