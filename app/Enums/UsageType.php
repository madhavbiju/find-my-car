<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum UsageType: string
{
    use HasLabel;

    case City = 'city';
    case Highway = 'highway';
    case Mixed = 'mixed';

    private function langGroup(): string
    {
        return 'usage';
    }
}
