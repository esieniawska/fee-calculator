<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Service;

use PragmaGoTech\Interview\Domain\Shared\ValueObject\Money;

interface FeeRounder
{
    public function roundFee(Money $amount, Money $fee): Money;
}
