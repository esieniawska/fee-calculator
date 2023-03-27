<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Infrastructure\Proposal\Service;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Domain\Proposal\Model\FeeStructure;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFee;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFeeRange;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;
use PragmaGoTech\Interview\Infrastructure\Proposal\Exception\LoanFeeRangeNotFound;
use PragmaGoTech\Interview\Infrastructure\Proposal\Service\BinaryFeeRangeFinder;

class BinaryFeeRangeFinderTest extends TestCase
{
    /**
     * @dataProvider getFeeDataProvider
     */
    public function testSuccessfulFindRange(int $value, array $feeStructures, LoanFeeRange $expectedRange): void
    {
        $finder = new BinaryFeeRangeFinder();
        $resultRange = $finder->findFeeRange(new Money($value), new FeeStructure($feeStructures));
        $this->assertEquals($expectedRange, $resultRange);
    }

    public function testFailedFindRangeWhenValueIsLessThanTheRange(): void
    {
        $finder = new BinaryFeeRangeFinder();
        $this->expectException(LoanFeeRangeNotFound::class);
        $finder->findFeeRange(
            new Money(5),
            new FeeStructure([
                new LoanFee(new Money(10), new Money(2)),
                new LoanFee(new Money(15), new Money(3)),
                new LoanFee(new Money(20), new Money(4)),
                new LoanFee(new Money(25), new Money(5)),
            ])
        );
    }

    public function testFailedFindRangeWhenValueIsGreaterThanTheRange(): void
    {
        $finder = new BinaryFeeRangeFinder();
        $this->expectException(LoanFeeRangeNotFound::class);
        $finder->findFeeRange(
            new Money(26),
            new FeeStructure([
                new LoanFee(new Money(10), new Money(2)),
                new LoanFee(new Money(15), new Money(3)),
                new LoanFee(new Money(20), new Money(4)),
                new LoanFee(new Money(25), new Money(5)),
            ])
        );
    }

    public function getFeeDataProvider(): array
    {
        return [
            [
                'value'         => 12,
                'feeStructures' => [
                    new LoanFee(new Money(5), new Money(1)),
                    new LoanFee(new Money(10), new Money(2)),
                    new LoanFee(new Money(15), new Money(3)),
                    new LoanFee(new Money(20), new Money(4)),
                    new LoanFee(new Money(25), new Money(5)),
                ],
                'result'        => new LoanFeeRange(
                    new LoanFee(new Money(10), new Money(2)),
                    new LoanFee(new Money(15), new Money(3)),
                ),
            ],
            [
                'value'         => 22,
                'feeStructures' => [
                    new LoanFee(new Money(5), new Money(1)),
                    new LoanFee(new Money(10), new Money(2)),
                    new LoanFee(new Money(15), new Money(3)),
                    new LoanFee(new Money(20), new Money(4)),
                    new LoanFee(new Money(25), new Money(5)),
                ],
                'result'        => new LoanFeeRange(
                    new LoanFee(new Money(20), new Money(4)),
                    new LoanFee(new Money(25), new Money(5)),
                ),
            ],
            [
                'value'         => 37,
                'feeStructures' => [
                    new LoanFee(new Money(5), new Money(1)),
                    new LoanFee(new Money(10), new Money(2)),
                    new LoanFee(new Money(15), new Money(3)),
                    new LoanFee(new Money(20), new Money(4)),
                    new LoanFee(new Money(25), new Money(5)),
                    new LoanFee(new Money(30), new Money(6)),
                    new LoanFee(new Money(35), new Money(7)),
                    new LoanFee(new Money(40), new Money(8)),

                ],
                'result'        => new LoanFeeRange(
                    new LoanFee(new Money(35), new Money(7)),
                    new LoanFee(new Money(40), new Money(8)),
                ),
            ],
            [
                'value'         => 5,
                'feeStructures' => [
                    new LoanFee(new Money(5), new Money(1)),
                    new LoanFee(new Money(10), new Money(2)),
                    new LoanFee(new Money(15), new Money(3)),
                    new LoanFee(new Money(20), new Money(4)),
                ],
                'result'        => new LoanFeeRange(
                    new LoanFee(new Money(5), new Money(1)),
                    new LoanFee(new Money(5), new Money(1)),
                ),
            ],
            [
                'value'         => 30,
                'feeStructures' => [
                    new LoanFee(new Money(5), new Money(1)),
                    new LoanFee(new Money(10), new Money(2)),
                    new LoanFee(new Money(15), new Money(3)),
                    new LoanFee(new Money(20), new Money(4)),
                    new LoanFee(new Money(25), new Money(5)),
                    new LoanFee(new Money(30), new Money(6)),

                ],
                'result'        => new LoanFeeRange(
                    new LoanFee(new Money(30), new Money(6)),
                    new LoanFee(new Money(30), new Money(6)),
                ),
            ],
            [
                'value'         => 5,
                'feeStructures' => [
                    new LoanFee(new Money(5), new Money(1)),
                ],
                'result'        => new LoanFeeRange(
                    new LoanFee(new Money(5), new Money(1)),
                    new LoanFee(new Money(5), new Money(1)),
                ),
            ],
        ];
    }
}