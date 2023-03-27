<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Application\Proposal\Service;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Application\Proposal\Service\TwelveMonthsLinearFeeCalculatorService;
use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;
use PragmaGoTech\Interview\Domain\Proposal\Model\FeeStructure;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanAmount;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFee;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFeeRange;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanProposal;
use PragmaGoTech\Interview\Domain\Proposal\Repository\FeeStructureRepository;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeFinder;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRangeFinder;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRounder;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;
use Prophecy\Prophet;

class TwelveMonthsLinearFeeCalculatorServiceTest extends TestCase
{
    private Prophet $prophet;

    public function testSuccessfulCalculate(): void
    {
        $amount = new Money(100000);
        $repositoryMock = $this->prophet->prophesize(FeeStructureRepository::class);

        $repositoryMock
            ->getFeeStructureForDuration(LoanDuration::TWELVE_MONTHS())
            ->willReturn(
                $feeStructure = (new FeeStructure(
                    [
                        $loanFee = new LoanFee(new Money(1000), new Money(100)),
                    ]
                ))
            )
            ->shouldBeCalledOnce();

        $feeRangeFinderMock = $this->prophet->prophesize(FeeRangeFinder::class);

        $feeRangeFinderMock
            ->findFeeRange($amount, $feeStructure)
            ->willReturn($range = new LoanFeeRange($loanFee, $loanFee))
            ->shouldBeCalledOnce();

        $feeFinderMock = $this->prophet->prophesize(FeeFinder::class);

        $feeFinderMock
            ->findFeeFromRange($amount, $range)
            ->willReturn($fee = new Money(1000))
            ->shouldBeCalledOnce();

        $feeRounderMock = $this->prophet->prophesize(FeeRounder::class);

        $feeRounderMock
            ->roundFee($amount, $fee)
            ->willReturn(new Money(9990))
            ->shouldBeCalledOnce();

        $service = new TwelveMonthsLinearFeeCalculatorService(
            $repositoryMock->reveal(),
            $feeRangeFinderMock->reveal(),
            $feeFinderMock->reveal(),
            $feeRounderMock->reveal()
        );

        $result = $service->calculate(new LoanProposal(new LoanAmount($amount)));
        $this->assertInstanceOf(Money::class, $result);
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
