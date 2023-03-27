<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Domain\Shared\ValueObject;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

class MoneyTest extends TestCase
{
    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulCreateMoney(int $value, float $floatValue): void
    {
        $money = new Money($value);
        $this->assertEquals($floatValue, $money->getFloatValue());
        $this->assertEquals($value, $money->getIntValue());
    }

    public function getDataProvider(): array
    {
        return [
            [
                'value'      => 200,
                'floatValue' => 2,
            ],
            [
                'value'      => 199,
                'floatValue' => 1.99,
            ],
            [
                'value'      => 150,
                'floatValue' => 1.5,
            ],
            [
                'value'      => 21000000000,
                'floatValue' => 210000000,
            ],
            [
                'value'      => 0,
                'floatValue' => 0,
            ],
        ];
    }
}