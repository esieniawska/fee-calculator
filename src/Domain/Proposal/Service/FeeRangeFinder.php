<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Service;

use PragmaGoTech\Interview\Domain\Proposal\Model\FeeStructure;
use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFeeRange;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

interface FeeRangeFinder
{
    public function findFeeRange(Money $value, FeeStructure $feeStructure): LoanFeeRange;
}
