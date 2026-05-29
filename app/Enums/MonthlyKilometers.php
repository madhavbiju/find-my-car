<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum MonthlyKilometers: string
{
    use HasLabel;

    case LessThanFiveHundred = 'less-than-500';
    case FiveHundredToThousand = '500-1000';
    case ThousandToTwoThousand = '1000-2000';
    case MoreThanTwoThousand = 'more-than-2000';

    private function langGroup(): string
    {
        return 'monthly_km';
    }
}
