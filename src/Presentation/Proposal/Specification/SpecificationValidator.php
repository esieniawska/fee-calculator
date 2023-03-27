<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Presentation\Proposal\Specification;

use PragmaGoTech\Interview\Presentation\Proposal\Exception\InvalidValueException;

readonly class SpecificationValidator
{
    public function __construct(private Specification $specification, private string $errorMessage)
    {
    }

    /**
     * @throws InvalidValueException
     */
    public function checkIsValidSpecification(?string $value): void
    {
        if (!$this->specification->isSatisfiedBy($value)) {
            throw new InvalidValueException($this->errorMessage);
        }
    }
}
