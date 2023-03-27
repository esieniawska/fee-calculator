<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Domain\Proposal\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static LoanDuration TWELVE_MONTHS()
 * @method static LoanDuration TWENTY_FOUR_MONTHS()
 */
class LoanDuration extends Enum
{
    public const TWELVE_MONTHS = 12;
    public const TWENTY_FOUR_MONTHS = 24;
}
