<?php

namespace App\Enums;

use App\Enums\Concerns\HasLabel;

enum BudgetRange: string
{
    use HasLabel;

    case UnderFive = 'under-5';
    case FiveToTen = '5-10';
    case TenToFifteen = '10-15';
    case FifteenToTwenty = '15-20';
    case TwentyToThirty = '20-30';
    case AboveThirty = 'above-30';

    /**
     * @return array{0: int|null, 1: int|null}
     */
    public function priceBounds(): array
    {
        return match ($this) {
            self::UnderFive => [null, 500000],
            self::FiveToTen => [500000, 1000000],
            self::TenToFifteen => [1000000, 1500000],
            self::FifteenToTwenty => [1500000, 2000000],
            self::TwentyToThirty => [2000000, 3000000],
            self::AboveThirty => [3000000, null],
        };
    }

    private function langGroup(): string
    {
        return 'budget';
    }
}
