<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Tests\Domain\Proposal\Model;

use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanAmount;
use PragmaGoTech\Interview\Domain\Shared\Exception\InvalidValueException;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

class LoanAmountTest extends TestCase
{
    /**
     * @dataProvider getDataProvider
     */
    public function testSuccessfulCreateLoanAmount(int $value): void
    {
        $loanAmount = new LoanAmount($money = (new Money($value)));
        $this->assertEquals($money, $loanAmount->getAmount());
    }

    public function testFailedCreateLoanAmountWhenTooSmallAmount(): void
    {
        $this->expectException(InvalidValueException::class);
        new LoanAmount(new Money(99999));
    }

    public function testFailedCreateLoanAmountWhenTooMuchAmount(): void
    {
        $this->expectException(InvalidValueException::class);
        new LoanAmount(new Money(2000001));
    }

    public function getDataProvider(): array
    {
        return [
            [
                'value' => 100000,
            ],
            [
                'value' => 2000000,
            ],
            [
                'value' => 1800000,
            ],
        ];
    }
}