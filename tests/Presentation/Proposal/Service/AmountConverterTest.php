<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Presentation\Proposal\Service;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Presentation\Proposal\Exception\InvalidValueException;
use PragmaGoTech\Interview\Presentation\Proposal\Service\AmountConverter;

class AmountConverterTest extends TestCase
{
    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulConvert(string $value, int $result): void
    {
        $amountConverter = new AmountConverter();
        $this->assertEquals($result, $amountConverter->getAmountInPennies($value));
    }

    public function testFailedConvertWhenNegativeNumber(): void
    {
        $amountConverter = new AmountConverter();

        $this->expectException(InvalidValueException::class);
        $amountConverter->getAmountInPennies('-310.11');
    }

    public function testFailedConvertWhenWrongFormat(): void
    {
        $amountConverter = new AmountConverter();

        $this->expectException(InvalidValueException::class);
        $amountConverter->getAmountInPennies('31.123');
    }

    public function getDataProvider(): array
    {
        return [
            [
                'value'  => '4504.99',
                'result' => 450499,
            ],
            [
                'value'  => '1',
                'result' => 100,
            ],
            [
                'value'  => '1.1',
                'result' => 110,
            ],
            [
                'value'  => '11.5',
                'result' => 1150,
            ],
        ];
    }
}