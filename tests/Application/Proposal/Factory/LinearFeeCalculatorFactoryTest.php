<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Application\Proposal\Model;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Application\Proposal\Exception\InvalidLoanDurationException;
use PragmaGoTech\Interview\Application\Proposal\Factory\LinearFeeCalculatorFactory;
use PragmaGoTech\Interview\Application\Proposal\Service\TwelveMonthsLinearFeeCalculatorService;
use PragmaGoTech\Interview\Application\Proposal\Service\TwentyFourMonthsLinearFeeCalculatorService;
use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;
use PragmaGoTech\Interview\Domain\Proposal\Repository\FeeStructureRepository;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeFinder;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRangeFinder;
use PragmaGoTech\Interview\Domain\Proposal\Service\FeeRounder;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

class LinearFeeCalculatorFactoryTest extends TestCase
{
    private Prophet $prophet;
    private ObjectProphecy|FeeStructureRepository $repositoryMock;
    private ObjectProphecy|FeeRangeFinder $feeRangeFinderMock;
    private ObjectProphecy|FeeFinder $feeFinderMock;
    private ObjectProphecy|FeeRounder $feeRounderMock;

    public function testSuccessfulCreateTwelveMonthsLinearFeeCalculatorService(): void
    {
        $factory = new LinearFeeCalculatorFactory(
            $this->repositoryMock->reveal(),
            $this->feeRangeFinderMock->reveal(),
            $this->feeFinderMock->reveal(),
            $this->feeRounderMock->reveal()
        );

        $result = $factory->createFeeCalculator(LoanDuration::TWELVE_MONTHS());
        $this->assertInstanceOf(TwelveMonthsLinearFeeCalculatorService::class, $result);
    }

    public function testSuccessfulCreateTwentyFourMonthsLinearFeeCalculatorService(): void
    {
        $factory = new LinearFeeCalculatorFactory(
            $this->repositoryMock->reveal(),
            $this->feeRangeFinderMock->reveal(),
            $this->feeFinderMock->reveal(),
            $this->feeRounderMock->reveal()
        );

        $result = $factory->createFeeCalculator(LoanDuration::TWENTY_FOUR_MONTHS());
        $this->assertInstanceOf(TwentyFourMonthsLinearFeeCalculatorService::class, $result);
    }

    public function testFailedCreateFeeStructureWhenDuration(): void
    {
        $factory = new LinearFeeCalculatorFactory(
            $this->repositoryMock->reveal(),
            $this->feeRangeFinderMock->reveal(),
            $this->feeFinderMock->reveal(),
            $this->feeRounderMock->reveal()
        );

        $durationMock = $this->prophet->prophesize(LoanDuration::class);
        $durationMock
            ->getValue()
            ->willReturn(15)
            ->shouldBeCalled();

        $this->expectException(InvalidLoanDurationException::class);
        $factory->createFeeCalculator($durationMock->reveal());
    }

    protected function setUp(): void
    {
        $this->prophet = new Prophet();
        $this->repositoryMock = $this->prophet->prophesize(FeeStructureRepository::class);
        $this->feeRangeFinderMock = $this->prophet->prophesize(FeeRangeFinder::class);
        $this->feeFinderMock = $this->prophet->prophesize(FeeFinder::class);
        $this->feeRounderMock = $this->prophet->prophesize(FeeRounder::class);
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
