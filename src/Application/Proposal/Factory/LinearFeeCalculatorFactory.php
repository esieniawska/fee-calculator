<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Application\Proposal\Factory;

use PragmaGoTech\Interview\Application\Proposal\Exception\InvalidLoanDurationException;
use PragmaGoTech\Interview\Application\Proposal\Service\LinearFeeCalculator;
use PragmaGoTech\Interview\Application\Proposal\Service\TwelveMonthsLinearFeeCalculatorService;
use PragmaGoTech\Interview\Application\Proposal\Service\TwentyFourMonthsLinearFeeCalculatorService;
use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;
use PragmaGoTech\Interview\Domain\Proposal\Repository\FeeStructureRepository;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeFinder;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRangeFinder;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRounder;

class LinearFeeCalculatorFactory
{
    public function __construct(
        private FeeStructureRepository $feeStructureRepository,
        private FeeRangeFinder $feeRangeFinder,
        private FeeFinder $feeFinder,
        private FeeRounder $feeRounder
    ) {
    }

    public function createFeeCalculator(LoanDuration $duration): LinearFeeCalculator
    {
        return match ($duration->getValue()) {
            LoanDuration::TWELVE_MONTHS => new TwelveMonthsLinearFeeCalculatorService(
                $this->feeStructureRepository,
                $this->feeRangeFinder,
                $this->feeFinder,
                $this->feeRounder,
            ),
            LoanDuration::TWENTY_FOUR_MONTHS => new TwentyFourMonthsLinearFeeCalculatorService(
                $this->feeStructureRepository,
                $this->feeRangeFinder,
                $this->feeFinder,
                $this->feeRounder,
            ),
            default => throw new InvalidLoanDurationException('Invalid loan duration')
        };
    }
}
