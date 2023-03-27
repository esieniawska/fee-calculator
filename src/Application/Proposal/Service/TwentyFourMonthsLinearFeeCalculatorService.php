<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Application\Proposal\Service;

use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;
use PragmaGoTech\Interview\Domain\Proposal\Model\FeeStructure;

class TwentyFourMonthsLinearFeeCalculatorService extends LinearFeeCalculator
{
    protected function getFeeStructure(): FeeStructure
    {
        return $this->feeStructureRepository->getFeeStructureForDuration(LoanDuration::TWENTY_FOUR_MONTHS());
    }
}
