<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Infrastructure\Proposal\Service;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;
use PragmaGoTech\Interview\Infrastructure\Proposal\Service\FeeRounderUp;

class FeeRounderUpTest extends TestCase
{
    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulConvert(int $amount, int $fee, int $result): void
    {
        $feeRounderUp = new FeeRounderUp();
        $this->assertEquals(new Money($result), $feeRounderUp->roundFee(new Money($amount), new Money($fee)));
    }

    public function getDataProvider(): array
    {
        return [
            [
                'amount' => 625,
                'fee'    => 300,
                'result' => 375,
            ],
            [
                'amount' => 100,
                'fee'    => 300,
                'result' => 400,
            ],
            [
                'amount' => 100027,
                'fee'    => 5001,
                'result' => 5473,
            ],
            [
                'amount' => 100099,
                'fee'    => 5100,
                'result' => 5401,
            ],
            [
                'amount' => 1,
                'fee'    => 0,
                'result' => 499,
            ],
            [
                'amount' => 1285,
                'fee'    => 158,
                'result' => 215,
            ],
        ];
    }
}