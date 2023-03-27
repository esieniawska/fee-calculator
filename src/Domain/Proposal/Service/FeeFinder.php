<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Service;

use PragmaGoTech\Interview\Domain\Proposal\Model\LoanFeeRange;
use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

interface FeeFinder
{
    public function findFeeFromRange(Money $value, LoanFeeRange $loanFeeRange): Money;
}
