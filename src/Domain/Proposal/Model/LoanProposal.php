<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Model;

readonly class LoanProposal
{
    public function __construct(private LoanAmount $loanAmount)
    {
    }

    public function getLoanAmount(): LoanAmount
    {
        return $this->loanAmount;
    }
}
