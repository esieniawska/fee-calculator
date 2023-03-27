<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Shared\Specification;

use PragmaGoTech\Interview\Domain\Shared\Exception\InvalidValueException;

readonly class SpecificationValidator
{
    public function __construct(private Specification $specification, private string $errorMessage)
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function checkIsValidSpecification(string|array|int|float $value): void
    {
        if (!$this->specification->isSatisfiedBy($value)) {
            throw new InvalidValueException($this->errorMessage);
        }
    }
}
