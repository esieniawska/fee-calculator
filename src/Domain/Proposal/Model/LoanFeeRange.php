<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Model;

readonly class LoanFeeRange
{
    public function __construct(private LoanFee $minRange, private LoanFee $maxRange)
    {
    }

    public function getMinLoanFee(): LoanFee
    {
        return $this->minRange;
    }

    public function getMaxLoanFee(): LoanFee
    {
        return $this->maxRange;
    }
}
