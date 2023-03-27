<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Application\Proposal\Service;

use PragmaGoTech\Interview\Domain\Proposal\Model\FeeStructure;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanProposal;
use PragmaGoTech\Interview\Domain\Proposal\Repository\FeeStructureRepository;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeCalculator;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeFinder;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRangeFinder;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRounder;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

abstract class LinearFeeCalculator implements FeeCalculator
{
    public function __construct(
        protected readonly FeeStructureRepository $feeStructureRepository,
        private readonly FeeRangeFinder $feeRangeFinder,
        private readonly FeeFinder $feeFinder,
        private readonly FeeRounder $feeRounder
    ) {
    }

    public function calculate(LoanProposal $loanProposal): Money
    {
        $loanAmount = $loanProposal->getLoanAmount()->getAmount();
        $feeStructure = $this->getFeeStructure();
        $loanFeeRange = $this->feeRangeFinder->findFeeRange($loanAmount, $feeStructure);
        $fee = $this->feeFinder->findFeeFromRange($loanAmount, $loanFeeRange);

        return $this->feeRounder->roundFee($loanAmount, $fee);
    }

    abstract protected function getFeeStructure(): FeeStructure;
}
