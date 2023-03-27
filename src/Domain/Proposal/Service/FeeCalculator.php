<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Service;

use PragmaGoTech\Interview\Domain\Proposal\Model\LoanProposal;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

interface FeeCalculator
{
    public function calculate(LoanProposal $loanProposal): Money;
}
