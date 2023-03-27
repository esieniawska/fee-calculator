<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Infrastructure\Proposal\Service;

use PragmaGoTech\Interview\Domain\Proposal\Model\FeeStructure;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFee;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFeeRange;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRangeFinder;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;
use PragmaGoTech\Interview\Infrastructure\Proposal\Exception\LoanFeeRangeNotFound;

class BinaryFeeRangeFinder implements FeeRangeFinder
{
    public function findFeeRange(Money $value, FeeStructure $feeStructure): LoanFeeRange
    {
        return $this->searchRange($value->getIntValue(), $feeStructure->getLoadFees());
    }

    private function searchRange(int $searchValue, $loadFees): LoanFeeRange
    {
        $firstKey = 0;
        $lastKey = count($loadFees) - 1;

        while ($firstKey <= $lastKey) {
            $middleKey = floor(($firstKey + $lastKey) / 2);
            /**@var $middleLoanFee LoanFee */
            $middleLoanFee = $loadFees[$middleKey];
            $middleLoanFeeValue = $middleLoanFee->getAmount()->getIntValue();
            $nextMiddleLoanFee = $loadFees[$middleKey + 1] ?? $middleLoanFee;

            if ($searchValue === $middleLoanFeeValue) {
                return new LoanFeeRange($middleLoanFee, $middleLoanFee);
            }

            if ($this->isCorrectRange(
                $searchValue,
                $middleLoanFeeValue,
                $nextMiddleLoanFee->getAmount()->getIntValue()
            )) {
                return new LoanFeeRange($middleLoanFee, $nextMiddleLoanFee);
            }

            if ($middleLoanFeeValue > $searchValue) {
                $lastKey = $middleKey - 1;
            }

            if ($middleLoanFeeValue < $searchValue) {
                $firstKey = $middleKey + 1;
            }
        }

        throw new LoanFeeRangeNotFound('The searched value is not within the range of possible loans');
    }

    private function isCorrectRange(int $value, int $minValue, int $maxValue): bool
    {
        return $minValue < $value && $value < $maxValue;
    }
}
