<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum BodyType: string
{
    use HasLabel;

    case Hatchback = 'hatchback';
    case Sedan = 'sedan';
    case Suv = 'suv';
    case CompactSuv = 'compact-suv';
    case NoPreference = 'no-preference';

    private function langGroup(): string
    {
        return 'body_type';
    }
}
