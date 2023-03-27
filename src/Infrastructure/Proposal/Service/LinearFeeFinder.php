<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Infrastructure\Proposal\Service;

use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFeeRange;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeFinder;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

class LinearFeeFinder implements FeeFinder
{
    public function findFeeFromRange(Money $value, LoanFeeRange $loanFeeRange): Money
    {
        $minRange = $loanFeeRange->getMinLoanFee()->getAmount()->getIntValue();
        $maxRange = $loanFeeRange->getMaxLoanFee()->getAmount()->getIntValue();

        $minFee = $loanFeeRange->getMinLoanFee()->getFee()->getIntValue();
        $maxFee = $loanFeeRange->getMaxLoanFee()->getFee()->getIntValue();

        if ($minFee === $maxFee) {
           return $loanFeeRange->getMinLoanFee()->getFee();
        }

        $feeValue = ($value->getIntValue() - $minRange) / ($maxRange - $minRange) * ($maxFee - $minFee) + $minFee;

        return $this->createFeeMoney($feeValue);
    }

    private function createFeeMoney(float $fee): Money
    {
        return new Money((int)($fee));
    }
}
