<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Infrastructure\Proposal\Service;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFee;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFeeRange;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;
use PragmaGoTech\Interview\Infrastructure\Proposal\Service\LinearFeeFinder;

class LinearFeeFinderTest extends TestCase
{
    /**
     * @dataProvider getFeeDataProvider
     */
    public function testSuccessfulCalculateLinearFee(
        int $value,
        int $minRange,
        int $maxRange,
        int $minFee,
        int $maxFee,
        int $expectedResult
    ): void {
        $calc = new LinearFeeFinder();

        $result = $calc->findFeeFromRange(
            new Money($value),
            new LoanFeeRange(
                new LoanFee(new Money($minRange), new Money($minFee)),
                new LoanFee(new Money($maxRange), new Money($maxFee))
            )
        );

        $this->assertEquals((new Money($expectedResult))->getIntValue(), $result->getIntValue());
    }

    private function getFeeDataProvider(): array
    {
        return [
            [
                'value'    => 11500,
                'minRange' => 11000,
                'maxRange' => 12000,
                'minFee'   => 440,
                'maxFee'   => 480,
                'result'   => 460,
            ],
            [
                'value'    => 19250,
                'minRange' => 19000,
                'maxRange' => 20000,
                'minFee'   => 380,
                'maxFee'   => 400,
                'result'   => 385,
            ],
            [
                'value'    => 12,
                'minRange' => 10,
                'maxRange' => 20,
                'minFee'   => 10,
                'maxFee'   => 20,
                'result'   => 12,
            ],
            [
                'value'    => 5,
                'minRange' => 5,
                'maxRange' => 10,
                'minFee'   => 8,
                'maxFee'   => 10,
                'result'   => 8,
            ],
            [
                'value'    => 14001,
                'minRange' => 14000,
                'maxRange' => 15000,
                'minFee'   => 280,
                'maxFee'   => 300,
                'result'   => 280,
            ],
            [
                'value'    => 14002,
                'minRange' => 14000,
                'maxRange' => 15000,
                'minFee'   => 280,
                'maxFee'   => 300,
                'result'   => 280,
            ],
            [
                'value'    => 1000,
                'minRange' => 1000,
                'maxRange' => 1000,
                'minFee'   => 50,
                'maxFee'   => 50,
                'result'   => 50,
            ],
        ];
    }
}