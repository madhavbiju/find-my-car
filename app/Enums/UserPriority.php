<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum UserPriority: string
{
    use HasLabel;

    case Safety = 'safety';
    case Mileage = 'mileage';
    case Comfort = 'comfort';
    case Performance = 'performance';
    case Features = 'features';
    case Value = 'value';

    private function langGroup(): string
    {
        return 'priority';
    }
}
