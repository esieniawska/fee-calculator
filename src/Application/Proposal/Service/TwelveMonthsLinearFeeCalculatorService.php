<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Application\Proposal\Service;

use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;
use PragmaGoTech\Interview\Domain\Proposal\Model\FeeStructure;

class TwelveMonthsLinearFeeCalculatorService extends LinearFeeCalculator
{
    protected function getFeeStructure(): FeeStructure
    {
        return $this->feeStructureRepository->getFeeStructureForDuration(LoanDuration::TWELVE_MONTHS());
    }
}
