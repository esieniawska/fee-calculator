<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Application\Proposal\Service;

use PragmaGoTech\Interview\Application\Proposal\Dto\CreateLoanProposalInput;
use PragmaGoTech\Interview\Application\Proposal\Dto\FeeOutput;
use PragmaGoTech\Interview\Application\Proposal\Factory\LinearFeeCalculatorFactory;
use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanAmount;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanProposal;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

final readonly class LinearFeeCalculatorService
{
    public function __construct(private LinearFeeCalculatorFactory $loanProposalFactory)
    {
    }

    public function calculateFee(CreateLoanProposalInput $input): FeeOutput
    {
        $loanProposal = new LoanProposal(new LoanAmount(new Money($input->getAmount())));
        $calculator = $this->loanProposalFactory->createFeeCalculator(new LoanDuration($input->getTerm()));

        return new FeeOutput($calculator->calculate($loanProposal)->getFloatValue());
    }
}
