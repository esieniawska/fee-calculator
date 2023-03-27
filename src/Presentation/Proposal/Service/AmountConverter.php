<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Presentation\Proposal\Service;

use PragmaGoTech\Interview\Presentation\Proposal\Specification\SpecificationValidator;
use PragmaGoTech\Interview\Presentation\Proposal\Specification\StringHasValidPatternSpecification;

class AmountConverter
{
    private const MONEY_PATTERN = '/^[0-9]+(\.[0-9]{1,2})?$/';

    public function getAmountInPennies(string $value): int
    {
        $this->checkIsValidValue($value);
        return (int)round(100 * (float)$value);
    }

    private function checkIsValidValue(string $value): void
    {
        $validator = new SpecificationValidator(
            new StringHasValidPatternSpecification(self::MONEY_PATTERN),
            'Invalid amount format.'
        );

        $validator->checkIsValidSpecification($value);
    }
}
