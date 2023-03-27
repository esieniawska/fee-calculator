<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Infrastructure\Proposal\Repository;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;
use PragmaGoTech\Interview\Domain\Proposal\Model\FeeStructure;
use PragmaGoTech\Interview\Infrastructure\Proposal\Exception\FeeStructureNotFoundException;
use PragmaGoTech\Interview\Infrastructure\Proposal\Repository\InMemoryFeeStructureRepository;
use Prophecy\Prophet;

class InMemoryFeeStructureRepositoryTest extends TestCase
{
    private Prophet $prophet;

    public function testSuccessfulCreateFeeStructure(): void
    {
        $repository = new InMemoryFeeStructureRepository();

        $feeStructure = $repository->getFeeStructureForDuration(LoanDuration::TWELVE_MONTHS());

        $this->assertInstanceOf(FeeStructure::class, $feeStructure);
    }

    public function testFailedCreateFeeStructureWhenDuration(): void
    {
        $repository = new InMemoryFeeStructureRepository();

        $durationMock = $this->prophet->prophesize(LoanDuration::class);
        $durationMock
            ->getValue()
            ->willReturn(15)
            ->shouldBeCalled();

        $this->expectException(FeeStructureNotFoundException::class);

        $repository->getFeeStructureForDuration($durationMock->reveal());
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
