<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum FuelType: string
{
    use HasLabel;

    case Petrol = 'petrol';
    case Diesel = 'diesel';
    case Hybrid = 'hybrid';
    case Electric = 'electric';
    case NoPreference = 'no-preference';

    private function langGroup(): string
    {
        return 'fuel_type';
    }
}
