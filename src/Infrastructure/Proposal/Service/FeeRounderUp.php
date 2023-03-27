<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Infrastructure\Proposal\Service;

use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRounder;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

class FeeRounderUp implements FeeRounder
{
    private const MULTIPLE = 500;

    public function roundFee(Money $amount, Money $fee): Money
    {
        $sum = $this->createSum($amount, $fee);

        if ($this->checkIfSumIsRounded($sum)) {
            return $fee;
        }

        return $this->createRoundedFee($sum, $fee);
    }

    private function createSum(Money $amount, Money $fee): Money
    {
        return new Money($amount->getIntValue() + $fee->getIntValue());
    }

    private function checkIfSumIsRounded(Money $sum): bool
    {
        return $sum->getIntValue() % self::MULTIPLE === 0;
    }

    private function createRoundedFee(Money $sum, Money $fee): Money
    {
        $nextMultiple = $this->roundSumToNextMultipleValue($sum);
        $valueToAdd = $nextMultiple - $sum->getIntValue();

        return new Money($valueToAdd + $fee->getIntValue());
    }

    private function roundSumToNextMultipleValue(Money $sum): int
    {
        return (int)ceil($sum->getIntValue() / self::MULTIPLE) * self::MULTIPLE;
    }
}
