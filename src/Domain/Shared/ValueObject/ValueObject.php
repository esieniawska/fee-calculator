<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Shared\ValueObject;

use PragmaGoTech\Interview\Domain\Shared\Specification\SpecificationValidator;
use PragmaGoTech\Interview\Domain\Shared\Exception\InvalidValueException;

abstract class ValueObject
{
    /**
     * @param SpecificationValidator[] $validators
     *
     * @throws InvalidValueException
     */
    protected function ensureIsSatisfiedValue(string|array|int|float $value, array $validators): void
    {
        foreach ($validators as $validator) {
            $validator->checkIsValidSpecification($value);
        }
    }
}
