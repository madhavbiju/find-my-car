<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum Transmission: string
{
    use HasLabel;

    case Manual = 'manual';
    case Automatic = 'automatic';
    case NoPreference = 'no-preference';

    private function langGroup(): string
    {
        return 'transmission';
    }
}
