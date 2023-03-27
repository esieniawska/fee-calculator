<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Model;

use PragmaGoTech\Interview\Domain\Shared\Specification\SpecificationValidator;
use PragmaGoTech\Interview\Domain\Shared\Specification\ValuesAreBetweenAcceptedValuesSpecification;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\ValueObject;

class LoanAmount extends ValueObject
{
    private const MIN_VALUE = 100000;
    private const MAX_VALUE = 2000000;

    public function __construct(private readonly Money $amount)
    {
        $this->ensureIsSatisfiedValue($amount->getIntValue(), $this->getValidators());
    }

    private function getValidators(): array
    {
        return [
            new SpecificationValidator(
                new ValuesAreBetweenAcceptedValuesSpecification(self::MIN_VALUE, self::MAX_VALUE),
                sprintf(
                    'The loan amount must be a minimum of %s and a maximum of %s',
                    (new Money(self::MIN_VALUE))->getFloatValue(),
                    (new Money(self::MAX_VALUE))->getFloatValue()
                )
            ),
        ];
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}
