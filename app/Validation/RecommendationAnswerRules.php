<?php

namespace App\Validation;

use App\Enums\BodyType;
use App\Enums\BudgetRange;
use App\Enums\FamilySize;
use App\Enums\FuelType;
use App\Enums\MonthlyKilometers;
use App\Enums\Transmission;
use App\Enums\UsageType;
use App\Enums\UserPriority;
use Illuminate\Validation\Rule;

class RecommendationAnswerRules
{
    /**
     * @return array<string, array<int, mixed>>
     */
    public static function rules(): array
    {
        return [
            'budget' => ['required', Rule::enum(BudgetRange::class)],
            'usage' => ['required', Rule::enum(UsageType::class)],
            'family_size' => ['required', Rule::enum(FamilySize::class)],
            'monthly_km' => ['required', Rule::enum(MonthlyKilometers::class)],
            'fuel_type' => ['required', Rule::enum(FuelType::class)],
            'body_type' => ['required', Rule::enum(BodyType::class)],
            'transmission' => ['required', Rule::enum(Transmission::class)],
            'priority' => ['required', Rule::enum(UserPriority::class)],
        ];
    }
}
