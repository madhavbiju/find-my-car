<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum FamilySize: string
{
    use HasLabel;

    case OneToTwo = '1-2';
    case ThreeToFour = '3-4';
    case FivePlus = '5-plus';

    private function langGroup(): string
    {
        return 'family_size';
    }
}
