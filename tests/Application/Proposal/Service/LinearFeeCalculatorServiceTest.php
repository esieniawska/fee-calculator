<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Application\Proposal\Service;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Application\Proposal\Dto\CreateLoanProposalInput;
use PragmaGoTech\Interview\Application\Proposal\Dto\FeeOutput;
use PragmaGoTech\Interview\Application\Proposal\Factory\LinearFeeCalculatorFactory;
use PragmaGoTech\Interview\Application\Proposal\Service\LinearFeeCalculatorService;
use PragmaGoTech\Interview\Application\Proposal\Service\TwelveMonthsLinearFeeCalculatorService;
use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanAmount;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanProposal;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;
use Prophecy\Prophet;

class LinearFeeCalculatorServiceTest extends TestCase
{
    private Prophet $prophet;

    public function testSuccessfulCreateLinearFeeCalculatorService(): void
    {
        $calculatorMock = $this->prophet->prophesize(TwelveMonthsLinearFeeCalculatorService::class);
        $calculatorMock
            ->calculate(new LoanProposal(new LoanAmount(new Money(100000))))
            ->willReturn(new Money(5000))
            ->shouldBeCalledOnce();

        $loanProposalFactoryMock = $this->prophet->prophesize(LinearFeeCalculatorFactory::class);
        $loanProposalFactoryMock
            ->createFeeCalculator(LoanDuration::TWELVE_MONTHS())
            ->willReturn($calculatorMock->reveal())
            ->shouldBeCalledOnce();
        $input = new CreateLoanProposalInput(12, 100000);

        $service = new LinearFeeCalculatorService($loanProposalFactoryMock->reveal());

        $result = $service->calculateFee($input);
        $this->assertInstanceOf(FeeOutput::class, $result);
        $this->assertEquals($result->getFee(), 50);
    }

    protected function setUp(): void
    {
        $this->prophet = new Prophet();
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
