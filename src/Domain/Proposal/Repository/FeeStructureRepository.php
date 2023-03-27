<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Repository;

use PragmaGoTech\Interview\Domain\Proposal\Model\FeeStructure;
use PragmaGoTech\Interview\Domain\Proposal\Enum\LoanDuration;

interface FeeStructureRepository
{
    public function getFeeStructureForDuration(LoanDuration $duration): FeeStructure;
}
